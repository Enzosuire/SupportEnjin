<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projet;
use App\Customer;

class ProjetController extends Controller
{
    public function create(){

        $customers = Customer::get();

    return view('projet.createpro',['customers' => $customers]);
}
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required',
            'date_sortie_site' => 'required|date',
            'maintenance_preventive' => 'nullable|string',
            'duree_garantie' => 'nullable',
            'id_customers' => 'required|exists:customers,id',
        ]);

        // Exclusion du champ _token de l'assignation de masse
        $data = $request->except(['_token']);

        // Création d'un nouveau projet et enregistrement en base de données
        Projet::create($data);

        return redirect()->route('projet.createpro')->with('success', 'Projet créé avec succès.');
    }

    public function show($id)
    {
        $projet = Projet::with('customer')->findOrFail($id);
        return view('projet.show', compact('projet'));
    }
}
