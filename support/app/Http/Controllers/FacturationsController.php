<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Projet;
use App\Intervention;
use App\Facturations;

class FacturationsController extends Controller
{
    
    public function create(){
        $customers = Customer::get();
        $projets = Projet::with('customer')->get();
        $interventions = Intervention::get();
    
        return view('Facturations.createFa', ['customers' => $customers, 'projets' => $projets,'interventions' =>$interventions]);
}
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'montant' => 'required',
            'date_facturation' => 'required|date',
            'Numero_facturation' => 'nullable|string',
            'Forfait_heure' => 'nullable|integer',
            'pole' => 'nullable|string',
            'id_customers' => 'required|exists:customers,id',
            'id_projet' => 'required|exists:projet,id', 
        ]);

        // Exclusion du champ _token de l'assignation de masse
        $data = $request->except(['_token']);

        // Création d'une nouvelle facturation et enregistrement en base de données
        Facturations::create($data);

        return redirect()->route('Facturations.createFa')->with('success', 'Facturations créé avec succès.');

    }

    public function show($id)
    {
        $facturations = Facturations::findOrFail($id);
        return view('Facturations.show', compact('facturations'));
    }
    
    
}
