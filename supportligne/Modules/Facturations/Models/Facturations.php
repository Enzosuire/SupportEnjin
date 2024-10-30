<?php

namespace Modules\Facturations\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Projet\Models\Projet;


class Facturations extends Model
{
    protected $table = 'facturations';

    protected $fillable = ['id_projet', 'montant', 'date_facturation', 'Numero_facturation', 'Forfait_heure', 'pole', 'created_at', 'updated_at'];



    // Relation avec Projet
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'id_projet');
    }
    
    // //Relation avec facturations
    public function facturation()
    {
        return $this->belongsTo(Facturations::class, 'id_projet');
    }
}
    


