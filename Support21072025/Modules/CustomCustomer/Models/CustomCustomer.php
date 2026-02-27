<?php

namespace Modules\CustomCustomer\Models;

use App\Customer as BaseCustomer;

class CustomCustomer extends BaseCustomer
{
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'customer_projet', 'id_customers', 'id_projet');
    }
}