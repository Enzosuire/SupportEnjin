<?php

namespace Modules\Projet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Projet\Models\Projet;
use App\Customer;

class ProjetController extends Controller
{
    //Création projet 
    public function create(Request $request)
    {
        $customers = Customer::get();
        $customerId = $request->input('idCustomer');

        return view('projet::createpro', ['customers' => $customers, 'customerId' => $customerId]);
    }

    //Méthode traitement création Formulaire
    public function store(Request $request)
    {

        try {
            // Validation des données
            $request->validate([
                'nom' => 'required',
                'date_sortie_site' => 'nullable|date',
                'maintenance_preventive' => 'nullable|string',
                'duree_garantie' => 'nullable',
                'customers' => 'nullable|array', // Validation des clients associés
                'customers.*' => 'exists:customers,id', // Validation des IDs des clients
            ]);

            // Création du projet
            $projet = Projet::create($request->only([
                'nom',
                'date_sortie_site',
                'maintenance_preventive',
                'duree_garantie',
            ]));

              // Association des clients au projet via la table de liaison
            $projet->customers()->attach($request->input('customers'));

            return redirect()->route('projet.show')->with('success', 'Projet créé avec succès.');
        } catch (\Exception $e) {
            Log::error($e);

            // Rediriger vers la page d'erreur en cas d'exception
            return view('projet::errors/error');
            
        }
    }

    public function show($id_customer = null)
    {
        // Si un ID de client est fourni, récupérez les projets associés
        if ($id_customer) {
            $customer = Customer::findOrFail($id_customer);
            $projets = $customer->projets()->with('customers')->get();
        } else {
            // Sinon, récupérez tous les projets
            $projets = Projet::with('customers')->get();
        }

        // Calculer la date de fin de garantie pour chaque projet
        $projets->each(function ($projet) {
            $projet->date_fin_garantie = date('Y-m-d', strtotime($projet->date_sortie_site . ' + ' . $projet->duree_garantie . ' months'));
        });

        // Grouper les projets par client (même si tous les projets sont affichés, on peut garder cette logique)
        $groupedProjets = $projets->groupBy(function ($projet) {
            return $projet->customers->isEmpty() ? 'sans_client' : $projet->customers->first()->id;
        });

        // Retourner la vue avec la liste des projets
        return view('projet::show', compact('groupedProjets'));
    }


    //methode pour le lien entre la page clients et projets
    // public function showByCustomer($id_customer)
    // {
    //     // Récupérer le client spécifique avec ses projets associés
    //     $customer = Customer::findOrFail($id_customer);
        
    //     // Récupérer les projets liés à ce client
    //     $projets = $customer->projets()->with('customers')->get();

    //     // Calculer la date de fin de garantie pour chaque projet
    //     $projets->each(function ($projet) {
    //         $projet->date_fin_garantie = date('Y-m-d', strtotime($projet->date_sortie_site . ' + ' . $projet->duree_garantie . ' months'));
    //     });

    //     // Retourner la vue avec uniquement les projets de ce client
    //     return view('projet::show', compact('projets'));
    // }

    

    // public function show()
    // {
    //     // Récupérer tous les projets de la base de données
    //     $projets = Projet::all();

    //     // Retourner la vue avec les projets
    //     return view('projet::show', compact('projets'));
    // }


    // Mise à jour projet 
    public function update(Request $request, $customerId, $id)
    {
        $projet = Projet::find($id);
        $customers = Customer::get();

        return view('projet::updatepro', compact('projet', 'customers', 'customerId'));
    }



    //Méthode traitement mise à jour formualire traitement
    public function update_projet_traitement(Request $request)
    {

        try {
            // Validation des données
            $request->validate([
                'nom' => 'required',
                'date_sortie_site' => 'required|date',
                'maintenance_preventive' => 'nullable|string',
                'duree_garantie' => 'nullable',
                'id_customers' => 'required|exists:customers,id',
            ]);

            // Mise à jour du projet
            $projet = Projet::find($request->id);
            $projet->nom = $request->nom;
            $projet->date_sortie_site = $request->date_sortie_site;
            $projet->maintenance_preventive = $request->maintenance_preventive;
            $projet->duree_garantie = $request->duree_garantie;
            // $projet->id_customers = $request->id_customers;
            $projet->save();


            // return redirect()->route('projet.show', ['idCustomer' => $request->id_customers])->with('success', 'Projet modifié avec succès.');
            return redirect()->route('projet.show')->with('success', 'Projet modifié avec succès.');

            // return redirect()->route('projet.updatepro', ['customerId' => $request->id_customers, 'id' => $projet->id])->with('success', 'Projet modifié avec succès.');

        } catch (\Exception $e) {
            Log::error($e);

            // Rediriger vers la page d'erreur en cas d'exception
            return view('projet::errors/error');
        }
    }

    //Suppression Projet
    public function delete($customerId, $id)
    {
        $projet = Projet::find($id);

        $projet->delete();

        return redirect()->route('projet.show', ['idCustomer' => $customerId])->with('success', 'Projet supprimé avec succès.');
    }
}
