<?php

namespace Modules\CustomCustomer\Models;

use App\Customer as BaseCustomer;

class CustomCustomer extends BaseCustomer {
    // Méthode personnalisée
    public function projects() {
        return $this->hasMany('Modules\Projet\Models\Projet');
    }
    
}