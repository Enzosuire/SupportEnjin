<?php

namespace Modules\CustomCustomer\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\CustomCustomer\Models\CustomCustomer;

class CustomCustomerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'customers');
    }

    public function register()
    {
        // Ici, "lier" le modèle CustomCustomer à son équivalent natif
        $this->app->bind('App\Models\Customer', function () {
            return new CustomCustomer();
        });
    }
}
