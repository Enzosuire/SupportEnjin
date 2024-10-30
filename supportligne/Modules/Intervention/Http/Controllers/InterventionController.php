<?php

namespace Modules\Intervention\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Intervention\Models\Intervention;
use Modules\Projet\Models\Projet;
use App\Customer; 
use App\User; 
use App\Conversation;


class InterventionController extends Controller
{

    public function createForm(Request $request)
    {
        $customers = Customer::get();
        $projets = Projet::with('customers')->get();
        $users = User::nonDeleted()->get();
        // Récupérez l'ID du client depuis la requête
        $customerId = $request->input('idCustomer');
        // Récupérez l'utilisateur connecté
        $loggedInUser = auth()->user();


        return view('intervention::create', ['customers' => $customers, 'users' => $users, 'projets' => $projets, 'customerId' => $customerId, 'loggedInUser' => $loggedInUser]);
    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'types_interventions' => 'required',
                'description' => 'nullable',
                'temps_alloue' => 'nullable|integer',
                'date_intervention' => 'required|date',
                'id_customers' => 'required|exists:customers,id',
                'id_users' => 'required|exists:users,id',
                'id_projet' => 'required|exists:projet,id',
            ]);


            // Création d'une nouvelle intervention et enregistrement en base de données
            Intervention::create($request->all());

            return redirect()->route('intervention.create')->with('success', 'Intervention créée avec succès.');
        } catch (\Exception $e) {
            // Enregistrez l'exception dans les logs
            Log::error($e);

            // Rediriger vers la page d'erreur en cas d'exception
            return view('intervention::errors/error');
        }
    }

    //     public function show()
    // {
    //     // Récupérer tous les projets de la base de données
    //     $interventions = Intervention::all();

    //     // Retourner la vue avec les projets
    //     return view('interventions::show', compact('interventions'));
    // }


    // public function show($id_projet = null)
    // {
    //     // Récupérer toutes les interventions pour tous les projets
    //     $interventionsDuClientQuery = Intervention::with('projet.facturation', 'customer', 'user')
    //         ->orderBy('date_intervention', 'desc');
    
    //     // Si un id_projet est fourni, filtrer les interventions par projet
    //     if ($id_projet) {
    //         $interventionsDuClientQuery->where('id_projet', $id_projet);
    //     }
    
    //     // Exécuter la requête pour obtenir les interventions
    //     $interventionsDuClient = $interventionsDuClientQuery->get();
        
    //     // Récupérer tous les projets
    //     $projets = Projet::all();
        
    
    //     // Calculer les types d'interventions distincts
    //     $typesinterventions = Intervention::distinct()->pluck('types_interventions');
    
    //     // Calculer le temps alloué total pour toutes les interventions
    //     $tempsAlloueClient = $interventionsDuClient->sum('temps_alloue');
    
    //     // Initialiser les tableaux de temps restant, temps alloué par projet et forfait heure
    //     $tempsRestantParProjet = [];
    //     $tempsAlloueParProjet = [];
    //     $forfaitHeureParProjet = [];
    
    //     // Calculer le temps restant et le temps alloué pour chaque projet
    //     foreach ($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet) {
    //         $firstInterventionProjet = $interventionsProjet->first();
    
    //         if ($firstInterventionProjet && $firstInterventionProjet->projet && $firstInterventionProjet->projet->facturation) {
    //             $forfaitHeureProjet = $firstInterventionProjet->projet->facturation->Forfait_heure;
    //         } else {
    //             Log::warning('Aucune facturation trouvée pour le projet ' . optional($firstInterventionProjet->projet)->nom);
    //             $forfaitHeureProjet = null;
    //         }
            
    //         // Somme de temps_alloue pour les interventions du projet
    //         $tempsAlloueInterventions = $interventionsProjet->sum('temps_alloue');
            
    //         $tempsAlloueProjet = $tempsAlloueInterventions;
    
    //         $tempsRestantProjet = $forfaitHeureProjet - $tempsAlloueProjet;
    
    //         // Stocker le temps restant pour ce projet
    //         $tempsRestantParProjet[$projetId] = $tempsRestantProjet;
    
    //         // Stocker le temps alloué pour ce projet
    //         $tempsAlloueParProjet[$projetId] = $tempsAlloueProjet;
    
    //         // Stocker le forfait heure pour ce projet
    //         $forfaitHeureParProjet[$projetId] = $forfaitHeureProjet;
    //     }
    
    //     return view('intervention::show', compact('interventionsDuClient', 'tempsRestantParProjet', 'tempsAlloueParProjet', 'forfaitHeureParProjet', 'typesinterventions', 'projets'
    //     ));
    // }

 

    public function show($id_projet = null)
    {
        // Récupérer toutes les interventions, éventuellement filtrées par projet
        $interventionsDuClientQuery = Intervention::with('projet.facturation', 'customer', 'user')
            ->orderBy('date_intervention', 'desc');

        // Si un id_projet est fourni, filtrer les interventions par projet
        if ($id_projet) {
            $interventionsDuClientQuery->where('id_projet', $id_projet);
        }

        // Exécuter la requête pour obtenir les interventions
        $interventionsDuClient = $interventionsDuClientQuery->get();

        // Récupérer les conversations ayant un id_projet
        $conversations = Conversation::with(['timelogs', 'customer', 'user', 'projet', 'jiraIssues'])
            ->whereNotNull('id_projet') // Filtrer les conversations qui ont un id_projet
            ->get()
            ->each(function ($conversation) {
                // Récupérer les clés des tickets Jira
                $conversation->jira_keys = $conversation->jiraIssues->pluck('key')->all();
            });

        // Filtrer seulement les conversations ayant du temps passé (time_spent > 0)
        $conversationsFiltrees = $conversations->filter(function ($conversation) {
            return $conversation->timelogs->sum('time_spent') > 0;
        });

        // Concaténer les interventions et les conversations filtrées
        $interventionsDuClient = $interventionsDuClient->merge($conversationsFiltrees);

        // Calculer le temps total passé en conversations filtrées
        $tempsSpentConversations = $conversationsFiltrees->sum(function ($conversation) {
            return $conversation->timelogs->sum('time_spent');
        });

        // Récupérer tous les projets
        $projets = Projet::all();

        // Calculer les types d'interventions distincts
        $typesinterventions = Intervention::distinct()->pluck('types_interventions');

        // Calculer le temps alloué total pour toutes les interventions et conversations
        $tempsAlloueClient = $interventionsDuClient->sum(function ($intervention) {
            // Additionner temps_alloue pour les interventions et time_spent pour les conversations
            return ($intervention instanceof \Modules\Intervention\Models\Intervention) ? $intervention->temps_alloue : $intervention->timelogs->sum('time_spent');
        });

        // Calculer le temps restant du contrat
        $projetsDuClient = Projet::join('customer_projet', 'projet.id', '=', 'customer_projet.id_projet')
            ->get();  

        $tempsRestantContrat = max(0, $projetsDuClient->sum(function ($projet) {
            $facturation = $projet->facturation;
            return $facturation ? $facturation->Forfait_heure : 0;
        }) - $tempsAlloueClient);

        // Initialiser les tableaux de temps restant, temps alloué par projet et forfait heure
        $tempsRestantParProjet = [];
        $tempsAlloueParProjet = [];
        $forfaitHeureParProjet = [];

        // Calculer le temps restant et le temps alloué pour chaque projet
        foreach ($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet) {
            $firstInterventionProjet = $interventionsProjet->first();

            if ($firstInterventionProjet && $firstInterventionProjet->projet) {
                $forfaitHeureProjet = $firstInterventionProjet->projet->facturation ? $firstInterventionProjet->projet->facturation->Forfait_heure : 0;
            } else {
                Log::warning('Aucune facturation trouvée pour le projet ' . optional($firstInterventionProjet->projet)->nom);
                $forfaitHeureProjet = 0;
            }

            // Somme de temps_alloue pour les interventions et time_spent pour les conversations du projet
            $tempsAlloueInterventions = $interventionsProjet->sum(function ($intervention) {
                return ($intervention instanceof \Modules\Intervention\Models\Intervention) ? $intervention->temps_alloue : $intervention->timelogs->sum('time_spent');
            });

            $tempsAlloueProjet = $tempsAlloueInterventions;
            $tempsRestantProjet = $forfaitHeureProjet - $tempsAlloueProjet;

            // Stocker le temps restant pour ce projet
            $tempsRestantParProjet[$projetId] = $tempsRestantProjet;

            // Stocker le temps alloué pour ce projet
            $tempsAlloueParProjet[$projetId] = $tempsAlloueProjet;

            // Stocker le forfait heure pour ce projet
            $forfaitHeureParProjet[$projetId] = $forfaitHeureProjet;
        }

        return view('intervention::show', compact('interventionsDuClient', 'tempsRestantContrat', 'projetsDuClient','typesinterventions','tempsRestantParProjet','tempsAlloueParProjet', 'forfaitHeureParProjet', 'id_projet','projets'
        ));
    }



    
    public function update(Request $request, $customerId, $id)
    {
        $uneIntervention = Intervention::findOrFail($id);
        $projets = Projet::with('customers')->get();
        $customers = Customer::all();
        $users = User::nonDeleted()->get();

        return view('intervention::updateint', [
            'uneIntervention' => $uneIntervention,
            'customers' => $customers,
            'projets' => $projets,
            'users' => $users,
            'customerId' => $customerId,
        ]);
    }


    //Méthode traitement mise à jour formualire traitement
    public function update_interventions_traitement(Request $request)
    {

        try {
            // Validation des données
            $request->validate([
                'types_interventions' => 'required',
                'description' => 'nullable',
                'temps_alloue' => 'nullable|integer',
                'date_intervention' => 'required|date',
                // 'id_customers' => 'required|exists:customers,id',
                'id_users' => 'required|exists:users,id',
                'id_projet' => 'required|exists:projet,id',
            ]);

            // Mise à jour Intervention
            $uneIntervention = Intervention::find($request->id);
            $uneIntervention->types_interventions = $request->types_interventions;
            $uneIntervention->description = $request->description;
            $uneIntervention->temps_alloue = $request->temps_alloue;
            $uneIntervention->date_intervention = $request->date_intervention;
            // $uneIntervention->id_customers = $request->id_customers;
            $uneIntervention->id_projet = $request->id_projet;
            $uneIntervention->id_users = $request->id_users;
            $uneIntervention->save();


            return redirect()->route('intervention.show', ['idCustomer' => $request->id_customers])->with('success', 'Interventions modifié avec succès.');
        } catch (\Exception $e) {
            Log::error($e);


            return view('intervention::errors/error');
        }
    }

    //Suppression Interventions
    public function delete($customerId, $id)
    {
        $uneIntervention = Intervention::findOrFail($id);

        $uneIntervention->delete();

        return redirect()->route('intervention.show', ['idCustomer' => $customerId])->with('success', 'Interventions supprimé avec succès.');
    }
}
