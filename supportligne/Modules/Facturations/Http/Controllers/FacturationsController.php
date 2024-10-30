<?php

namespace Modules\Facturations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Modules\Facturations\Models\Facturations;
use Modules\Projet\Models\Projet;


class FacturationsController extends Controller
{
    //création Facturation
    public function create(Request $request)
    {

        $projets = Projet::get();
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


    public function show($id_projet = null)
    {
        // Récupérer tous les projets
        $projets = Projet::all();

        // Si un id_projet est fourni, récupérer les facturations associées, sinon récupérer toutes les facturations
        if ($id_projet) {
            $facturations = Facturations::where('id_projet', $id_projet)->get();
        } else {
            $facturations = Facturations::all();  // Récupérer toutes les facturations
        }

        // Retourner la vue avec les facturations, les projets, et le id_projet
        return view('facturations::show', compact('facturations', 'projets', 'id_projet'));
    }

    //   public function show()
    // {
    //     // Récupérer tous les projets de la base de données
    //     $facturations = Facturations::all();

    //     // Retourner la vue avec les projets
    //     return view('facturations::show', compact('facturations'));
    // }



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
