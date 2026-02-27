<?php

namespace Modules\Projet\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Facturations\Models\Facturations;
use App\Customer; 

class Projet extends Model
{
    protected $table = 'projet';

    public $timestamps = false;

    protected $fillable = ['nom', 'maintenance_preventive','customers', 'creasite', 'type_projet',];
   

    public function facturation()
    {
        return $this->hasOne(Facturations::class, 'id_projet');
    }
   
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_projet', 'id_projet', 'id_customers');
    }
    

    

}
