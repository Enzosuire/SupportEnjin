<?php

namespace Modules\Projet\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class CreateProjetTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('projet')->insert([
            [
                'nom' => 'Projet 3',
                'date_sortie_site' => '2024-01-01',
                'maintenance_preventive' => 'Préventive 1',
                'duree_garantie' => '6 ans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Projet 4',
                'date_sortie_site' => '2024-02-01',
                'maintenance_preventive' => 'Préventive 2',
                'duree_garantie' => '8 ans',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
