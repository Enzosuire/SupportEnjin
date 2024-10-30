<?php
namespace Modules\Intervention\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateInterventionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        public function run()
        {
            DB::table('interventions')->insert([
                [
                    'types_interventions' => 'Maintenance préventive',
                    'description' => 'test affichage intervention.',
                    'date_intervention' => '2024-09-23 13:01:47',
                    'id_users' => 1, // Remplacer par un ID d'utilisateur existant
                    'id_projet' => 1, // Remplacer par un ID de projet existant
                    'temps_alloue' => 60, // En min
                    'numero_ticket_jira' => 'JIRA-048',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
                // [
                //     // 'types_interventions' => 'Correction de bug',
                //     // 'description' => 'Correction d’un bug critique sur le backend.',
                //     // 'date_intervention' => Carbon::now(),
                //     // 'id_users' => 2, // Remplacer par un ID d'utilisateur existant
                //     // 'id_projet' => 2, // Remplacer par un ID de projet existant
                //     // 'temps_alloue' => 8,
                //     // 'numero_ticket_jira' => 'JIRA-002',
                //     // 'created_at' => Carbon::now(),
                //     // 'updated_at' => Carbon::now(),
                // ],
                // [
                //     // 'types_interventions' => 'Amélioration de performance',
                //     // 'description' => 'Optimisation des requêtes de la base de données.',
                //     // 'date_intervention' => Carbon::now(),
                //     // 'id_users' => 3, // Remplacer par un ID d'utilisateur existant
                //     // 'id_projet' => 1, // Remplacer par un ID de projet existant
                //     // 'temps_alloue' => 6,
                //     // 'numero_ticket_jira' => 'JIRA-003',
                //     // 'created_at' => Carbon::now(),
                //     // 'updated_at' => Carbon::now(),
                // ],
            ]);
        }
    }

