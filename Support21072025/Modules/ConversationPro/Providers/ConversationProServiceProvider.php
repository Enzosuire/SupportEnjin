<?php

namespace Modules\ConversationPro\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\ConversationPro\Models\ConversationPro;

class ConversationProServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'conversationpro');
        
    }

    

    public function register()
    {
        // Ici, "lier" le modèle ConversationPro à son équivalent natif
        $this->app->bind('App\Models\Conversation', function () {
            return new ConversationPro();
        });

        
    }
}
