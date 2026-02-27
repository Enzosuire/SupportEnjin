<?php

namespace Modules\Projet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Projet\Models\Projet;
use App\Customer;
use App\User;


class ProjetController extends Controller
{

    // Création projet
    public function create(Request $request)
    {
        $customers = Customer::orderBy('company')->get();
        $users = User::all(); // Récupère tous les utilisateurs pour les référents
        $customerId = $request->input('idCustomer');

        return view('projet::createpro', [
            'customers' => $customers,
            'users' => $users, // Envoie les utilisateurs à la vue
            'customerId' => $customerId
        ]);
    }

    //Méthode traitement création Formulaire

      public function store(Request $request)
    {
        try {
          
            // Règles communes
            $baseRules = [
                'nom' => 'required|string|max:191',
                'type_projet' => 'required|string|in:web,print',
                'company' => 'required|string|exists:customers,company',
                'selected_customers' => 'required|array|min:1', 
                'selected_customers.*' => 'exists:customers,id',
            ];


            // Règles spécifiques au type "web"
            $webRules = [
                'date_sortie_site' => 'nullable|date',
                'maintenance_preventive' => 'nullable|string|in:oui,non',
                'duree_garantie' => 'nullable|integer|min:0',
                'creasite' => 'nullable|string|in:oui,non',
                'selected_customers' => 'required|array',
                'selected_customers.*' => 'exists:customers,id',
                'referent_web' => 'nullable|exists:users,id',
                'referent_seo' => 'nullable|exists:users,id',
                'referent_commercial' => 'nullable|exists:users,id',
            ];

            // Appliquer les règles selon le type de projet
            $rules = $baseRules;
            if ($request->type_projet === 'web') {
                $rules = array_merge($rules, $webRules);
            }

            // Validation des données
            $validatedData = $request->validate($rules);
            


            // Création du projet avec les champs de base
            $projetData = [
                'nom' => $validatedData['nom'],
                'type_projet' => $validatedData['type_projet'], // Forcer explicitement
                'company' => $validatedData['company'] ,
            ];



            // Ajouter les champs spécifiques au web si nécessaire
            if ($validatedData['type_projet'] === 'web') {
                $projetData = array_merge($projetData, [
                    'date_sortie_site' => $validatedData['date_sortie_site'] ?? null,
                    'maintenance_preventive' => $validatedData['maintenance_preventive'] ?? null,
                    'duree_garantie' => $validatedData['duree_garantie'] ?? null,
                    'creasite' => $validatedData['creasite'] ?? null,
                ]);
            }

            $projet = Projet::create($projetData);
            

            // Associer les clients au projet pour **tous** les types de projet
            if (isset($validatedData['selected_customers'])) {
                $projet->customers()->attach($validatedData['selected_customers']);
            }


            // Récupérer et stocker les noms des référents (seulement pour les projets web)
            if ($validatedData['type_projet'] === 'web') {
                $referentWeb = User::find($request->input('referent_web'));
                $referentSeo = User::find($request->input('referent_seo'));
                $referentCommercial = User::find($request->input('referent_commercial'));

                // Stocker les noms des référents dans les colonnes du projet
                $projet->referent_web_name = $referentWeb ? $referentWeb->first_name . ' ' . $referentWeb->last_name : null;
                $projet->referent_seo_name = $referentSeo ? $referentSeo->first_name . ' ' . $referentSeo->last_name : null;
                $projet->referent_commercial_name = $referentCommercial ? $referentCommercial->first_name . ' ' . $referentCommercial->last_name : null;

                // Sauvegarder le projet avec les noms des référents
                $projet->save();
            }

            return redirect()->route('projet.show')->with('success', 'Projet créé avec succès.');
            
        } catch (\Exception $e) {
            Log::error($e);
            
            // Rediriger vers la page d'erreur en cas d'exception
            return view('projet::errors/error');
        }
    }




    

    public function show($id_customers = null)
    {
        $search = request('search');

        $customers = Customer::orderBy('company', 'asc')->get();

        // Filtrer par client si un ID est fourni
        if ($id_customers) {
            $customer = Customer::findOrFail($id_customers);
            $projets = $customer->projets()->with('customers')->get();
        } else {
            // Sinon, récupérer tous les projets avec les clients
            $projets = Projet::with('customers')->get();
        }

        // Filtrage par nom de client
        if (!empty($search)) {
            $projets = $projets->filter(function ($projet) use ($search) {
                return $projet->customers->contains(function ($customer) use ($search) {
                    return stripos($customer->company, $search) !== false;
                });
            });
        }

        // Calcul date de fin de garantie
        $projets->each(function ($projet) {
            if (!empty($projet->date_sortie_site) && !empty($projet->duree_garantie)) {
                $projet->date_fin_garantie = date('Y-m-d', strtotime($projet->date_sortie_site . ' + ' . $projet->duree_garantie . ' months'));
            } else {
                $projet->date_fin_garantie = null;
            }
        });


        // Regroupement des projets par client
        $groupedProjets = [];
        foreach ($projets as $projet) {
            foreach ($projet->customers as $customer) {
                $groupedProjets[$customer->id]['customer'] = $customer;
                $groupedProjets[$customer->id]['projets'][] = $projet;
            }
        }

        return view('projet::show', compact('groupedProjets', 'customers'));
    }







    public function update(Request $request, $customerId, $id)
    {
        // Récupérer le projet avec ses clients associés
        $projet = Projet::with('customers')->find($id);

        // Récupérer tous les clients
        $customers = Customer::all();

        // Récupérer tous les utilisateurs pour les référents
        $users = User::all();

        return view('projet::updatepro', compact('projet', 'customers', 'customerId', 'users'));
    }


    // Méthode traitement mise à jour formulaire traitement
    public function update_projet_traitement(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'nom' => 'required',
                'type_projet' => 'required|string|in:web,print',
                'date_sortie_site' => 'nullable|date',
                'maintenance_preventive' => 'nullable|string',
                'duree_garantie' => 'nullable',
                'creasite' => 'nullable|string',
                'selected_customers' => 'required|array',
                'selected_customers.*' => 'exists:customers,id',
                'referent_web' => 'nullable|exists:users,id',
                'referent_seo' => 'nullable|exists:users,id',
                'referent_commercial' => 'nullable|exists:users,id',

            ]);

            // Récupérer le projet
            $projet = Projet::find($request->id);

            // Mise à jour des informations du projet
            $projet->nom = $request->nom;
            $projet->type_projet = $request->input('type_projet'); // <-- Ajout ici
            $projet->date_sortie_site = $request->date_sortie_site ?: null;
            $projet->maintenance_preventive = $request->maintenance_preventive;
            $projet->duree_garantie = $request->duree_garantie ?: null;
            $projet->creasite = $request->creasite;

            // Sauvegarder les informations de base du projet
            $projet->save();

            // Mise à jour des clients associés au projet
            if ($request->has('selected_customers')) {
                $projet->customers()->sync($request->selected_customers); // Synchroniser les clients sélectionnés
            }


            // Récupérer et assigner les référents (si présents)
            if ($request->referent_web) {
                $referentWeb = User::find($request->referent_web);
                $projet->referent_web_name = $referentWeb ? $referentWeb->first_name . ' ' . $referentWeb->last_name : null;
            }

            if ($request->referent_seo) {
                $referentSeo = User::find($request->referent_seo);
                $projet->referent_seo_name = $referentSeo ? $referentSeo->first_name . ' ' . $referentSeo->last_name : null;
            }

            if ($request->referent_commercial) {
                $referentCommercial = User::find($request->referent_commercial);
                $projet->referent_commercial_name = $referentCommercial ? $referentCommercial->first_name . ' ' . $referentCommercial->last_name : null;
            }

            // Sauvegarder les informations des référents
            $projet->save();

            // Redirection après la mise à jour
            return redirect()->route('projet.show')->with('success', 'Projet modifié avec succès.');
        } catch (\Exception $e) {
            // Log de l'erreur
            Log::error($e);

            // Redirection vers la page d'erreur
            return view('projet::errors/error');
        }
    }


    // Suppression Projet
    public function delete($customerId, $projectId)
    {
        // Trouver le projet
        $projet = Projet::findOrFail($projectId);

        // Dissocier le projet du client
        $projet->customers()->detach($customerId);

        // Vérifiez s'il n'y a plus de clients associés au projet
        if ($projet->customers()->count() === 0) {
            // Si le projet n'a plus de clients associés, vous pouvez le supprimer
            $projet->delete();
            return redirect()->route('projet.show')->with('success', 'Projet supprimé avec succès.');
        }

        return redirect()->route('projet.show')->with('success', 'Projet dissocié du client avec succès.');
    }
}
