<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $table = 'projet';

    public $timestamps = false;
  
    protected $fillable = [
        'nom', 'date_sortie_site','id_customers','maintenance_preventive', 'duree_garantie'
    ];
    public function customer()
    {
      
        return $this->belongsTo(Customer::class, 'id_customers');
    }

    public function facturation()
    {
        return $this->hasOne(Facturations::class, 'id_projet'); 
    }
    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'id_projet');
    }


}
