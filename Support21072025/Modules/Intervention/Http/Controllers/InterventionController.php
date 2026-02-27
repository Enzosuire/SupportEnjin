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
        $customers = Customer::orderBy('company')->get();
        $projets = Projet::with('customers')->orderBy('nom')->get();
        $users = User::nonDeleted()->get();
        // Récupérez l'ID du client depuis la requête
        $customerId = $request->input('id_customers'); 
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
                'temps_alloue' => 'required|integer',
                'date_intervention' => 'required|date',
                'id_customers' => 'required|exists:customers,id',
                'id_users' => 'required|exists:users,id',
                'id_projet' => 'required|exists:projet,id',
            ]);


            // Création d'une nouvelle intervention et enregistrement en base de données
            Intervention::create($request->all());

            return redirect()->to(route('intervention.show') . '?id_customers=' . $request->input('id_customers') . '&id_projet=' . $request->input('id_projet'))->with('success', 'Intervention créée avec succès.');

        } catch (\Exception $e) {
            // Enregistrez l'exception dans les logs
            Log::error($e);

            // Rediriger vers la page d'erreur en cas d'exception
            return view('intervention::errors/error');
        }
    }


 
    public function show(Request $request  , $id_customers = null , $id_projet = null)
    {
    
        // Récupérer les filtres avec priorité aux paramètres de l'URL
        $id_customers = $request->route('id_customers') ?? $request->query('id_customers');
        $id_projet = $request->route('id_projet') ?? $request->query('id_projet');


        // Récupérer toutes les interventions, éventuellement filtrées par projet
        $interventionsDuClientQuery = Intervention::with('projet.facturation', 'customer', 'user')
            ->orderBy('date_intervention', 'desc');

        // Si un id_projet est fourni, filtrer les interventions par projet
        if ($id_projet) {
            $interventionsDuClientQuery->where('id_projet', $id_projet);
        }

        // Exécuter la requête pour obtenir les interventions
        $interventionsDuClient = $interventionsDuClientQuery->get();

        // Récupérer les conversations ayant un id_projet et potentiellement filtrées par projet
        $conversationsQuery = Conversation::with(['timelogs', 'customer', 'user', 'projet', 'jiraIssues'])
            ->whereNotNull('id_projet'); // Filtrer les conversations qui ont un id_projet

        // Si un id_projet est fourni, filtrer les conversations par projet
        if ($id_projet) {
            $conversationsQuery->where('id_projet', $id_projet);
        }

       
        // Construire la requête de base
        $interventionsProjet = Intervention::query()
            ->select('interventions.*')
            ->join('projet', 'interventions.id_projet', '=', 'projet.id');
    
        // Si un client est spécifié
        if ($id_customers) {
            $interventionsProjet ->join('customer_projet', 'projet.id', '=', 'customer_projet.id_projet')
                        ->where('customer_projet.id_customers', '=', $id_customers);
        }

        // Exécuter la requête pour obtenir les conversations
        $conversations = $conversationsQuery->get()->each(function ($conversation) {
            // Récupérer les clés des tickets Jira
            $conversation->jira_keys = $conversation->jiraIssues->pluck('key')->all();
        });

        // Filtrer seulement les conversations ayant du temps passé (time_spent > 0)
        $conversationsFiltrees = $conversations->filter(function ($conversation) {
            return $conversation->timelogs->sum('time_spent') > 0;
        });

        // Concaténer les interventions et les conversations filtrées
        $interventionsDuClient = $interventionsDuClient->concat($conversationsFiltrees);

        // Calculer le temps total passé en conversations filtrées
        $tempsSpentConversations = $conversationsFiltrees->sum(function ($conversation) {
            return $conversation->timelogs->sum('time_spent');
        });

          // Récupérer tous les clients
        // $customers = Customer::all(); // Ajouter cette ligne pour récupérer les clients

        // // Récupérer tous les projets
        // $projets = Projet::all();

        $customers = Customer::orderBy('company', 'asc')->get();
        $projets = Projet::orderBy('nom', 'asc')->get();

        // Calculer les types d'interventions distincts
        $typesinterventions = Intervention::distinct()->pluck('types_interventions');

        // Calculer le temps alloué total pour toutes les interventions et conversations
        $tempsAlloueClient = $interventionsDuClient->sum(function ($intervention) {
            // Additionner temps_alloue pour les interventions et time_spent pour les conversations
            return ($intervention instanceof \Modules\Intervention\Models\Intervention) ? $intervention->temps_alloue : $intervention->timelogs->sum('time_spent') ;
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
                $forfaitHeureProjet = $firstInterventionProjet->projet->facturation ? $firstInterventionProjet->projet->facturation->where('id_projet', $projetId)->sum('Forfait_heure'): 0;
            } else {
                Log::warning('Aucune facturation trouvée pour le projet ' . optional($firstInterventionProjet->projet)->nom);
                $forfaitHeureProjet = 0;
            }

            // Somme de temps_alloue pour les interventions et time_spent pour les conversations du projet
            $tempsAlloueInterventions = $interventionsProjet->sum(function ($intervention) {
                return ($intervention instanceof \Modules\Intervention\Models\Intervention) ? $intervention->temps_alloue : $intervention->timelogs->sum('time_spent') / 60 ;
            });

            
            $tempsAlloueProjet = round($tempsAlloueInterventions ); // Arrondir en minutes

            $tempsRestantProjet = round($forfaitHeureProjet - $tempsAlloueProjet); // Arrondir le temps restant


            // Stocker le temps restant pour ce projet
            $tempsRestantParProjet[$projetId] = $tempsRestantProjet;

            // Stocker le temps alloué pour ce projet
            $tempsAlloueParProjet[$projetId] = $tempsAlloueProjet;

            // Stocker le forfait heure pour ce projet
            $forfaitHeureParProjet[$projetId] = $forfaitHeureProjet;
        }

        return view('intervention::show', compact('interventionsDuClient', 'tempsRestantContrat', 'projetsDuClient','typesinterventions','tempsRestantParProjet','tempsAlloueParProjet', 'forfaitHeureParProjet', 'id_projet','projets','customers', 'id_customers'));
    }




    

    public function update(Request $request, $customerId, $type, $id)
    {
        if ($type === 'intervention') {
            $uneIntervention = Intervention::findOrFail($id);
        } elseif ($type === 'conversation') {
            $uneIntervention = Conversation::findOrFail($id);
        } else {
            abort(404, 'Type invalide');
        }

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



  

    public function update_interventions_traitement(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'id' => 'required|integer',
                'type' => 'required|string|in:intervention,conversation', // Ajout explicite du type
                'id_customers' => 'required|integer',
                'id_projet' => 'required|integer|exists:projet,id',
                'id_users' => 'required|integer|exists:users,id',
                'description' => 'nullable|string',
                'subject' => 'nullable|string',
                'types_interventions' => 'nullable|string',
                'temps_alloue' => 'nullable|integer',
                'date_intervention' => 'required|date',
                'numero_ticket_jira' => 'nullable|string',
            ]);

            // Récupération basée sur le type
            if ($request->type === 'intervention') {
                $uneIntervention = Intervention::findOrFail($request->id);
            } elseif ($request->type === 'conversation') {
                $uneIntervention = Conversation::with('timelogs')->findOrFail($request->id);
            } else {
                throw new \Exception("Type d'entité inconnu.");
            }

            // Logique de mise à jour
            if ($uneIntervention instanceof Conversation) {
                // Mise à jour des conversations
                if ($request->has('time_spent')) {
                    $newTimeSpent = (int)$request->input('time_spent') * 60; // Conversion en secondes
                    foreach ($uneIntervention->timelogs as $timelog) {
                        $timelog->time_spent = $newTimeSpent;
                        $timelog->save();
                    }
                }

                $tempsPasseMinutes = $uneIntervention->timelogs->sum('time_spent') / 60; // Conversion en minutes
                $uneIntervention->update([
                    'description' => $request->description,
                    'subject' => $request->subject,
                    'temps_alloue' => $tempsPasseMinutes,
                    'date_intervention' => $request->date_intervention,
                    'numero_ticket_jira' => $request->numero_ticket_jira,
                    'id_projet' => $request->id_projet,
                    'id_users' => $request->id_users,
                ]);
            } else {
                // Mise à jour des interventions classiques
                $uneIntervention->update([
                    'types_interventions' => $request->types_interventions,
                    'description' => $request->description,
                    'temps_alloue' => $request->temps_alloue,
                    'date_intervention' => $request->date_intervention,
                    'numero_ticket_jira' => $request->numero_ticket_jira,
                    'id_projet' => $request->id_projet,
                    'id_users' => $request->id_users,
                ]);
            }

            return redirect()
                ->route('intervention.show')
                ->with('success', 'Intervention ou conversation modifiée avec succès.');

        } catch (\Exception $e) {
            Log::error($e);
            return view('intervention::errors/error');
        }
    }

    



    public function delete($customerId, $type, $id)
    {
        try {
            if ($type === 'intervention') {
                // Recherche et suppression d'une intervention
                $uneIntervention = Intervention::findOrFail($id);
                $uneIntervention->delete();
            } elseif ($type === 'conversation') {
                // Recherche d'une conversation
                $uneConversation = Conversation::findOrFail($id);
        
                // Vérifier si la conversation a des timelogs et les réinitialiser
                if ($uneConversation->timelogs()->exists()) {
                    $uneConversation->timelogs()->update(['time_spent' => 0]);
                }
            } else {
                // Type inconnu, lancer une exception
                abort(404, 'Type d’entité inconnu.');
            }
        
            return redirect()->route('intervention.show', ['idCustomer' => $customerId])
                ->with('success', 'Interventions supprimée avec succès.');
        } catch (\Exception $e) {
            // Enregistre les erreurs dans les logs pour débogage
            Log::error('Erreur lors de la suppression de l’interventions :', [
                'type' => $type,
                'id' => $id,
                'customerId' => $customerId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        
            return redirect()->route('intervention.show', ['idCustomer' => $customerId])
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
    


    
}
