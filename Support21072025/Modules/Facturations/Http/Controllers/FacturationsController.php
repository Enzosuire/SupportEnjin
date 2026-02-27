<?php

namespace Modules\Facturations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Facturations\Models\Facturations;
use Modules\Projet\Models\Projet;
use App\Customer;


class FacturationsController extends Controller
{
    //création Facturation
    public function create(Request $request)
    {

        $projets = Projet::orderBy('nom', 'asc')->get();
        // $interventions = Intervention::get();
        // Récupérez l'ID du client depuis la requête
        $projetId = $request->input('id_projet');

        return view('facturations::createFa', ['projetId' => $projetId, 'projets' => $projets]);
    }

    public function store(Request $request)
    {
        try {
            // Validation des données
            $request->validate([
                'montant' => 'required',
                'date_facturation' => 'required|date',
                'Numero_facturation' => 'nullable|string',
                'Forfait_heure' => 'nullable|integer',
                'pole' => 'nullable|string',
                'id_projet' => 'required|exists:projet,id',
            ]);


            // Création d'une nouvelle facturation et enregistrement en base de données
            Facturations::create($request->all());


            return redirect()->route('facturations.show')->with('success', 'Facturations créé avec succès.');
        } catch (\Exception $e) {

            Log::error($e);
            // Rediriger vers la page d'erreur en cas d'exception
            return view('facturations::errors/error');
        }
    }


    // public function show($id_projet = null)
    // {
    //     // Récupérer tous les projets
    //     $projets = Projet::all();

    //     // Si un id_projet est fourni, récupérer les facturations associées, sinon récupérer toutes les facturations
    //     if ($id_projet) {
    //         $facturations = Facturations::where('id_projet', $id_projet)->get();
    //     } else {
    //         $facturations = Facturations::all();  // Récupérer toutes les facturations
    //     }


    //     // Retourner la vue avec les facturations, les projets, et le id_projet
    //     return view('facturations::show', compact('facturations', 'projets', 'id_projet',  'pole'));
    // }

    // public function show(Request $request, $id_projet = null)
    // {
    //     // Récupérer tous les projets
    //     $projets = Projet::all();

    //     // Récupérer la valeur du paramètre 'pole' et 'date_facturation' de la requête
    //     $pole = $request->input('pole');
    //     $dateFacturation = $request->input('date_facturation');  // Récupérer la date sélectionnée

    //     // Filtrer les facturations en fonction du pôle et de la date de facturation
    //     $facturations = Facturations::query();  // Initialiser la requête

    //     // Filtrer par pôle si un pôle est sélectionné
    //     if ($pole) {
    //         $facturations->where('pole', $pole);
    //     }

    //     // Filtrer par date de facturation si une date est sélectionnée
    //     if ($dateFacturation) {
    //         $facturations->whereDate('date_facturation', $dateFacturation);  // Filtrer par date
    //     } elseif ($id_projet) {
    //         // Si un projet est spécifié, filtrer par projet
    //         $facturations->where('id_projet', $id_projet);
    //     }

    //     // Exécuter la requête et obtenir les résultats
    //     $facturations = $facturations->get();

    //     // Récupérer les pôles distincts pour l'affichage dans le sélecteur
    //     $poles = Facturations::distinct()->pluck('pole');  // Liste des pôles disponibles

    //     // Récupérer les dates distinctes pour l'affichage dans le sélecteur
    //     $dates = Facturations::distinct()->pluck('date_facturation');  // Liste des dates de facturation disponibles

    //     // Retourner la vue avec les données nécessaires
    //     return view('facturations::show', compact('facturations', 'projets', 'id_projet', 'poles', 'pole', 'dates', 'dateFacturation'));
    // }

    public function show(Request $request, $id_projet = null, $id_customers = null)
    {
        // Récupérer tous les projets et clients
        // $projets = Projet::all();
        // $customers = Customer::all();
        $projets = Projet::orderBy('nom', 'asc')->get();
        $customers = Customer::orderBy('company', 'asc')->get();

    
        // Récupérer les filtres avec priorité aux paramètres de l'URL
        $id_customers = $request->route('id_customers') ?? $request->query('id_customers');
        $id_projet = $request->route('id_projet') ?? $request->query('id_projet');
        $pole = $request->query('pole');
        $dateDebut = $request->query('date_debut');
        $dateFin = $request->query('date_fin');
    
        // Construire la requête de base
        $facturationsQuery = Facturations::query()
            ->select('facturations.*')
            ->join('projet', 'facturations.id_projet', '=', 'projet.id');
            
    
        // Si un client est spécifié
        if ($id_customers) {
            $facturationsQuery->join('customer_projet', 'projet.id', '=', 'customer_projet.id_projet')
                              ->where('customer_projet.id_customers', '=', $id_customers);
        }
    
        // Appliquer les autres filtres
        if ($id_projet) {
            $facturationsQuery->where('facturations.id_projet', $id_projet);
        }
    
        if ($pole) {
            $facturationsQuery->where('facturations.pole', $pole);
        }
    
        if ($dateDebut) {
            $facturationsQuery->where('facturations.date_facturation', '>=', $dateDebut);
        }
    
        if ($dateFin) {
            $facturationsQuery->where('facturations.date_facturation', '<=', $dateFin);
        }
    
        // Exécuter la requête
        $facturations = $facturationsQuery->distinct()->get(); // Récupérer les résultats

        // Calculer le total des montants
        $totalMontant = $facturations->sum('montant'); // Applique sum() après avoir exécuté la requête

        $totalFacturations = $facturations->count(); // Nombre de facturations filtrées
         // Paginée les résultats après les filtres
        $facturations = $facturationsQuery->distinct()->paginate(10);
    
        // Récupérer les pôles distincts
        $poles = Facturations::distinct()->pluck('pole');
    
    
        return view('facturations::show', compact(  'facturations', 'customers','id_customers','id_projet', 'poles','pole','projets','dateDebut', 'dateFin','totalMontant', 'totalFacturations'));
    }
    


    public function update($id_projet, $id)
    {
        // Récupérer la facturation à modifier
        $facturation = Facturations::find($id);
        // Récupérer tous les projets pour le sélecteur
        $projets = Projet::get();

        // Passer les données à la vue
        return view('facturations::updatefa', ['facturation' => $facturation, 'projets' => $projets, 'id_projet' => $id_projet]);
    }


    //Méthode traitement mise à jour formualire traitement
    public function update_facturations_traitement(Request $request)
    {

        try {
            // Validation des données
            $request->validate([
                'montant' => 'required',
                'date_facturation' => 'required|date',
                'Numero_facturation' => 'nullable|string',
                'Forfait_heure' => 'nullable|integer',
                'pole' => 'nullable|string',
                // 'id_customers' => 'required|exists:customers,id',
                'id_projet' => 'required|exists:projet,id',
            ]);

            // Mise à jour Facturation
            $facturation = Facturations::find($request->id);
            $facturation->montant = $request->montant;
            $facturation->date_facturation = $request->date_facturation;
            $facturation->Numero_facturation = $request->Numero_facturation;
            $facturation->Forfait_heure = $request->Forfait_heure;
            $facturation->pole = $request->pole;
            //    $facturation->id_customers = $request->id_customers;
            $facturation->id_projet = $request->id_projet;
            $facturation->save();


            return redirect()->route('facturations.show')->with('success', 'Facturation modifié avec succès.');
        } catch (\Exception $e) {
            Log::error($e);

            // Rediriger vers la page d'erreur en cas d'exception
            return view('facturations::errors/error');
        }
    }

    // return redirect()->route('facturations.show', ['id_projet' => $request->id_projet])->with('success', 'Facturation modifié avec succès.');

    public function delete($id_projet, $id)
    {
        $facturation = Facturations::find($id);

        $facturation->delete();

        return redirect()->route('facturations.show')->with('success', 'Facturation supprimé avec succès.');
    }
}
