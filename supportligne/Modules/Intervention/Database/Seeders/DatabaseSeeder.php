<?php

namespace Modules\Intervention\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CreateInterventionTableSeeder::class);
    }
}
