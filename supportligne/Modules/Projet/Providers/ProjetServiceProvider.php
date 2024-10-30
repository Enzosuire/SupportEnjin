<?php

namespace Modules\Projet\Providers;

use Illuminate\Support\ServiceProvider;

class ProjetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'projet');
    }

    public function register()
    {
        //
    }
}
