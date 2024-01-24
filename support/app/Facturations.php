<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturations extends Model
{
    protected $table = 'facturations';

    protected $fillable = ['id_projet','id_customers','montant', 'date_facturation','Numero_facturation','Forfait_heure','pole','created_at','updated_at'];
        // Relation avec Customer
        public function customer()
        {
            return $this->belongsTo(Customer::class, 'id_customers');
        }
    
        // Relation avec Projet
        public function projet()
        {
            return $this->belongsTo(Projet::class, 'id_projet');
        }

        //Relation avec interventions
        public function facturation()
        {
            return $this->belongsTo(Facturations::class,'id_projet');
        }
   
  

  



}


