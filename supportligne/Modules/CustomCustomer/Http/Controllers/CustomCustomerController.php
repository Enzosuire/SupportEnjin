<?php

namespace Modules\CustomCustomer\Http\Controllers;


use Modules\CustomCustomer\Models\CustomCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Customer; // Utilisation du modèle Customer
use App\Http\Controllers\CustomersController as BaseCustomersController;// Importation correcte

class CustomCustomerController extends BaseCustomersController { // Utilisation de BaseCustomerController

    // Tous les clients
    public function Customerall()
    {
        $customers = Customer::all();
        return view('customers::Customerall', ['customers' => $customers]);
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('customers::customercreate');
    }

    // Traite la soumission du formulaire
    public function store(Request $request)
    {
        try {
            // Récupérer les données du formulaire
            $data = $request->only(['first_name', 'last_name', 'company', 'numero_siret']);

            // Insérer manuellement les données dans la base de données
            $customer = new Customer();
            $customer->first_name = $data['first_name'];
            $customer->last_name = $data['last_name'];
            $customer->company = $data['company'];
            $customer->numero_siret = $data['numero_siret'];
            $customer->save();

            // Redirection avec message de succès
            return redirect()->route('customers.create')->with('success', 'Client créé avec succès.');
        } catch (\Exception $e) {
            Log::error($e);

            // Rediriger vers la page d'erreur en cas d'exception
            return view('CustomCustomer::errors/error')->with('error', 'Une erreur est survenue.');
        }
    }
}
