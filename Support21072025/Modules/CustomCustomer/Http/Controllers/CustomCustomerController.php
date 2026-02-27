<?php

namespace Modules\CustomCustomer\Http\Controllers;


use Modules\CustomCustomer\Models\CustomCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Email; 
use App\Customer; // Utilisation du modèle Customer
use Validator;
use App\Http\Controllers\CustomersController as BaseCustomersController;// Importation correcte

class CustomCustomerController extends BaseCustomersController { // Utilisation de BaseCustomerController

    // Tous les clients
    public function Customerall(Request $request)
    {
        // Tous les clients pour le sélecteur
        $allCustomers = Customer::orderBy('company', 'asc')->get();
        
        // Query de base
        $query = Customer::orderBy('company', 'asc');
        
        // Applique le filtre si un client est sélectionné
        if ($request->has('id_customers') && $request->id_customers != '') {
            $query->where('id', $request->id_customers);
        }

        // recherche textuelle (champ de recherche)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
            
        // Pagination sur la query filtrée
        $customers = $query->paginate(25);
        
        // Conserve le paramètre de filtre dans la pagination
        $customers->appends(['id_customers' => $request->id_customers]);
        
        return view('customers::Customerall', ['customers' => $customers, 'allCustomers' => $allCustomers]);
    }
    
    // Affiche le formulaire de création
 
    public function create()
    {
        $emails = old('emails', []); // Pour pré-remplir avec les anciennes valeurs
        return view('customers::customercreate', compact('emails'));
    }


    //Méthode de traitement formulaire de création clients
    public function store(Request $request)
    {
        try {
            // Valider les données du formulaire
            $validator = Validator::make($request->all(), [
                'first_name' => 'nullable|string|max:255',
                'last_name'  => 'nullable|string|max:255',
                'company'    => 'required|string|max:255',
                'numero_siret' => 'nullable|numeric',
                'phones'     => 'nullable|string|max:255',
                'websites'   => 'nullable|array',
                'emails.*'   => 'nullable|email|distinct|required_without:first_name',
            ]);


        // Traitement des emails, validation et enregistrement
         $emails = $request->input('emails', []);
    
            // Noms des attributs personnalisés pour les erreurs
            $validator->setAttributeNames([
                'emails.*' => __('Email'),
            ]);
    
            // Vérifier la validité et unicité des emails
            $fail = false;
            foreach ($request->emails as $i => $email) {
                $sanitized_email = Email::sanitizeEmail($email); // Assurez-vous que cette méthode existe
                if ($sanitized_email) {
                    $email_exists = Email::where('email', $sanitized_email)->first();
    
                    if ($email_exists) {
                        $validator->getMessageBag()->add('emails.' . $i, __('A customer with this email already exists.'));
                        $fail = true;
                    }
                }
            }
    
            if ($fail || $validator->fails()) {
                return redirect()->route('customers.create')
                    ->withErrors($validator)
                    ->withInput();
            }
    
            // Nettoyer le champ 'websites'
            $websites = $request->websites ? array_filter($request->websites, function ($value) {
                return !is_null($value);
            }) : [];
    
            // Créer le client
            $customer = new Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->company = $request->company;
            $customer->numero_siret = $request->numero_siret;
            $customer->phones = $request->phones;
            $customer->websites = json_encode($websites);
            $customer->save();
    
            // Associer les emails au client
            foreach ($request->emails as $email) {
                if (!empty($email)) {
                    $customerEmail = new Email();
                    $customerEmail->customer_id = $customer->id;
                    $customerEmail->email = Email::sanitizeEmail($email); // Assurez-vous que cette méthode existe
                    $customerEmail->save();
                }
            }
    
           
    
            // Redirection avec message de succès
            return redirect()->route('customers.Customerall')->with('success', __('Client créé avec succès.'));
    
        } catch (\Exception $e) {
            // Log de l'erreur pour le débogage
            Log::error($e);
    
            // Rediriger vers la page d'erreur en cas d'exception
            return view('customers::errors.error')->with('error', __('Une erreur est survenue.'));
        }
    }
    

}
