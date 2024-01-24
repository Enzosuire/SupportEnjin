<?php

use Illuminate\Database\Seeder;
use App\Facturations;

class FacturationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Facturations::create([
            'id_interventions' => 1, // Assurez-vous que cette intervention existe
            'id_customers' => 1, // Assurez-vous que ce client existe
            'id_projet' => 1, // Assurez-vous que ce projet existe
            'montant' => 100.00,
            'date_facturation' => now(),
            'statut' => 'payée',
            
        ]);
    }
}
