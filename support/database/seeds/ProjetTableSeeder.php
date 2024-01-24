<?php

use Illuminate\Database\Seeder;
use App\Projet;


class ProjetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Projet::create([
            'nom' => 'Projet Exemple',
            'date_sortie_site' => now(),
            'id_customers' => 2, // Assurez-vous que ce client existe dans la table `customers`
           
        ]);
    }
}
