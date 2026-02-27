<?php

namespace Modules\Projet\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CreateProjetTableSeeder::class);
    }
}
