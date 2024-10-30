<?php
namespace Modules\Facturations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateFacturationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('facturations')->insert([
            [
                'id_projet' => 1, // Remplace par un ID de projet existant
                'montant' => 1500.00,
                'date_facturation' => '2024-01-15',
                'Numero_facturation' => 'FAC-001',
                'Forfait_heure' => 10,
                'pole' => 'Développement',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_projet' => 2, // Remplace par un autre ID de projet existant
                'montant' => 2500.00,
                'date_facturation' => '2024-02-15',
                'Numero_facturation' => 'FAC-002',
                'Forfait_heure' => 15,
                'pole' => 'Support',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Ajoute d'autres facturations si nécessaire
        ]);
    }
}
