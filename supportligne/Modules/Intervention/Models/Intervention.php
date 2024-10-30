<?php

namespace Modules\Intervention\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Projet\Models\Projet;
use App\Customer; 
use App\User; 


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
        'id_users',
        'id_projet'
    ];
    // Relation avec Customer

    // public function customers()
    // {
    //     return $this->belongsTo(Customer::class, 'id_customers');
    // }

    // // Relation avec Customer via Projet

    // public function customer()
    // {
    //     return $this->hasOneThrough(Customer::class, Projet::class, 'id_projet', 'id_customers', 'id', 'id');
    // }

    public function customer()
    {
        return $this->belongsToMany(Customer::class, 'customer_projet', 'id_projet', 'id_customers',);
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
    


