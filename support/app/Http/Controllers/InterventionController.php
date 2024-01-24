<?php

namespace App\Http\Controllers;

use App\Timelogs;
use Illuminate\Http\Request;
use App\Intervention;
use App\User;
use App\Customer;
use App\Projet;
use App\Conversation;

class InterventionController extends Controller
{
    public function createForm()
    {
        $customers = Customer::get();
        $projets = Projet::with('customer')->get();
        $users = User::nonDeleted()->get();
        

        return view('interventions.create', ['customers' => $customers,'users' => $users, 'projets' => $projets]);
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'types_interventions' => 'required',
            'description' => 'nullable',
            'temps_alloue'=>'nullable|integer',
            'date_intervention' => 'required|date',
            'id_customers' => 'required|exists:customers,id',
            'id_users' => 'required|exists:users,id',
            'id_projet' => 'required|exists:projet,id',
        ]);
       
        // Exclusion du champ _token de l'assignation de masse
         $data = $request->except(['_token']);
        

        // Création d'une nouvelle intervention et enregistrement en base de données
        Intervention::create($data);

      
        return redirect()->route('interventions.create')->with('success', 'Intervention créée avec succès.');
    }

    public function show($idCustomer)
    {
        // Récupérer toutes les interventions pour le client spécifié avec les relations Eloquent
        $interventionsDuClient = Intervention::where('id_customers', $idCustomer)
            ->with('projet.facturation', 'customer', 'user',)
            ->orderBy('date_intervention', 'desc')
            ->get();

        // Récupérer toutes les conversations pour le client spécifié avec les relations Eloquent
        $conversations = Conversation::where('customer_id', $idCustomer)
        ->with('timelogs', 'customer', 'user', 'projet','jiraIssues',)
        ->get();

        // Ajouter les clés des tickets Jira à chaque conversation si elles existent
        foreach ($conversations as $conversation) {
            $jiraKeys = $conversation->jiraIssues->pluck('key')->all();
            $conversation->jira_keys = $jiraKeys;
        }
    
        // Concaténer les interventions et les conversations
        $interventionsDuClient = $interventionsDuClient->merge($conversations);

        $tempsSpentConversations = $conversations->sum(function ($conversation) {
            return $conversation->timelogs->sum('time_spent');
        });

        // Récupérer les projets du client une seule fois
        $projetsDuClient = Projet::where('id_customers', $idCustomer)->get();

        //distinct: Cela récupère toutes les lignes distinctes de la table  pluck : la colonne spécifiée dans la méthode 
        $typesinterventions = Intervention::distinct()->pluck('types_interventions');

        // Calculer le temps restant du contrat et le temps alloué total pour toutes les interventions du client
        $tempsAlloueClient = $interventionsDuClient->sum('temps_alloue') + $tempsSpentConversations;
        $tempsRestantContrat = max(0, $projetsDuClient->sum('facturation.Forfait_heure') - $tempsAlloueClient);


        // Initialiser les tableaux de temps restant et temps alloué par projet
        $tempsRestantParProjet = [];
        $tempsAlloueParProjet = [];

        // Calculer le temps restant et le temps alloué pour chaque projet
        foreach ($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet) {
            $forfaitHeureProjet = $interventionsProjet->first()->projet->facturation->Forfait_heure;
             // Somme de temps_alloue pour les interventions du projet
             $tempsAlloueInterventions = $interventionsProjet->sum('temps_alloue');

            // Somme de time_spent pour les conversations du projet
            $tempsSpentConversationsProjet = $interventionsProjet
            ->filter(function ($item) {
                return $item instanceof Conversation;
            })
            ->sum(function ($conversation) {
                return $conversation->timelogs->sum('time_spent');
            });
            
            // Calculer le temps alloué pour le projet en ajoutant les deux sommes
            $tempsAlloueProjet = $tempsAlloueInterventions + $tempsSpentConversationsProjet;

            $tempsRestantProjet =  $forfaitHeureProjet - $tempsAlloueProjet;
            
            // Stocker le temps restant pour ce projet
            $tempsRestantParProjet[$projetId] = $tempsRestantProjet;
            
            // Stocker le temps alloué pour ce projet
            $tempsAlloueParProjet[$projetId] = $tempsAlloueProjet;
        }


        return view('interventions.show', compact('interventionsDuClient', 'tempsRestantContrat', 'projetsDuClient', 'typesinterventions', 'tempsRestantParProjet', 'tempsAlloueParProjet', 'conversations'));

        }

        

    
}

//crée une nouvelle intervevntion a partir des conversations
// foreach ($conversations as $conversation) {
        // // Utiliser les relations pour accéder aux informations nécessaires
        // $id_customer = $conversation->customer->id;
        // $id_user = $conversation->user->id;
        // $id_projet = $conversation->projet->id;

        // // Calculer le temps alloué (exemple : somme des logs de temps)
        // $temps_alloue = $conversation->timelogs->sum('time_spent');

        // // Récupérer la dernière date de mise à jour à partir des timelogs
        // $dateintervention = $conversation->timelogs->last()->updated_at;

        // // Description de l'intervention
        // $description = $conversation->subject;

        // // Créer une nouvelle intervention
        // $intervention = Intervention::create([
        //     'id_customers' => $id_customer, 
        //     'id_users' => $id_user,         
        //     'id_projet' => $id_projet,       
        //     'temps_alloue' => $temps_alloue,
        //     'date_intervention' => $dateintervention,
        //     'description' => $description,
        // ]);
        // }


//   public function show($id)
// {
//     $intervention = Intervention::with('projet.facturation', 'customer', 'user')->findOrFail($id);
    

//     $tempsRestantContrat = null;

//     if ($intervention->projet && $intervention->projet->facturation) {
//         $forfaitHeure = $intervention->projet->facturation->Forfait_heure;

//         // Calculer le temps alloué dans toutes les interventions associées à ce projet
//         $tempsAlloueProjet = Intervention::where('id_projet', $intervention->projet->id)
//             ->sum('temps_alloue');

//         $tempsRestantContrat = max(0, $forfaitHeure - $tempsAlloueProjet);
//     }

//     // Récupérer toutes les interventions pour le client de l'intervention actuelle
//     $interventionsDuClient = Intervention::where('id_customers', $intervention->customer->id)
//         ->where('id_projet', $intervention->projet->id) 
//         ->orderBy('date_intervention', 'desc') // Triez par date décroissante
//         ->get();

//     //distinct: Cela récupère toutes les lignes distinctes de la table  pluck : la colonne spécifiée dans la méthode 
//     $typesinterventions = Intervention::distinct()->pluck('types_interventions');


//     // Passer les interventions et le client à la vue
//     return view('interventions.show', compact('intervention', 'tempsRestantContrat', 'interventionsDuClient','tempsAlloueProjet','typesinterventions'));
// }


// Stock le temps restant de la dernière intervention dans une variable distincte
// $tempsRestantDerniereIntervention = ($interventionsDuClient->last())->tempsRestantContrat;

// public function show($id)
// {
//     $intervention = Intervention::with('projet.facturation', 'customer', 'user')->findOrFail($id);

//     $tempsRestantContrat = null;

//     if ($intervention->projet && $intervention->projet->facturation) {
//         $forfaitHeure = $intervention->projet->facturation->Forfait_heure;

//         // Calculer le temps alloué dans toutes les interventions associées à ce projet
//         $tempsAlloueProjet = Intervention::where('id_projet', $intervention->projet->id)
//             ->sum('temps_alloue');

//         $tempsRestantContrat = max(0, $forfaitHeure - $tempsAlloueProjet);
//     }

//     // Récupérer toutes les interventions pour le client de l'intervention actuelle
//     $interventionsDuClient = Intervention::where('id_customers', $intervention->customer->id)
//         ->orderBy('date_intervention', 'desc') // Triez par date décroissante
//         ->get();

//     // Passer les interventions et le client à la vue
//     return view('interventions.show', compact('intervention', 'tempsRestantContrat', 'interventionsDuClient'));
// }



