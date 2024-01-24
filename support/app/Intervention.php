<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{

    protected $table = 'interventions';
    protected $guarded = ['_token'];

    protected $fillable = [ 

        'types_interventions', 
        'description', 
        'date_intervention', 
        'temps_alloue', 
        'numero_ticket_jira', 
        'id_customers', 
        'id_users', 
        'id_projet'
    ]; 
        // Relation avec Customer
        public function customer()
        {
            return $this->belongsTo(Customer::class, 'id_customers');
        }
    
        // Relation avec User
        public function user()
        {
            return $this->belongsTo(User::class, 'id_users');
        }
        // Relation avec projet
        
        public function projet()
        {
            return $this->belongsTo(Projet::class, 'id_projet');
        }
       
       
        
}
