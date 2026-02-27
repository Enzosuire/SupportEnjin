<?php

namespace Modules\Facturations\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CreateFacturationsTableSeeder::class);
    }
}
