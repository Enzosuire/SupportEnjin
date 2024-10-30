<?php

namespace Modules\Facturations\Providers;

use Illuminate\Support\ServiceProvider;

class FacturationsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'facturations');
    }

    public function register()
    {
        //
    }
}
