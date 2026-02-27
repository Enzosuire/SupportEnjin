<?php

namespace Modules\Intervention\Providers;

use Illuminate\Support\ServiceProvider;

class InterventionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'intervention');
    }

    public function register()
    {
        //
    }
}
