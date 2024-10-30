<?php

namespace Modules\Projet\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Facturations\Models\Facturations;
use App\Customer; 

class Projet extends Model
{
    protected $table = 'projet';

    public $timestamps = false;

    protected $fillable = ['nom', 'date_sortie_site', 'maintenance_preventive', 'duree_garantie','customers'];
    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class, 'id_customers');
    // }

    public function facturation()
    {
        return $this->hasOne(Facturations::class, 'id_projet');
    }
    // public function interventions()
    // {
    //     return $this->hasMany(Intervention::class, 'id_projet');
    // }

    // // Définir la relation plusieurs à plusieurs avec Customer
    // public function customers()
    // {
    //     return $this->belongsToMany(Customer::class, 'id_customers');
    // }
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_projet', 'id_projet', 'id_customers');
    }

    

}
