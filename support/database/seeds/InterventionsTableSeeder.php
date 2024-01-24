<?php

use Illuminate\Database\Seeder;
use App\Intervention;

class InterventionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Intervention::create([
            'types_interventions' => 'Type d\'intervention',
            'description' => 'Description de l\'intervention.',
            'date_intervention' => now(),
            'id_customers' => 2, 
            'id_users' => 2, 
            'temps_alloue'=> 3,
            'numero_ticket_jira'=> 'PR-123',
            

          
        ]);

    
    }
}
