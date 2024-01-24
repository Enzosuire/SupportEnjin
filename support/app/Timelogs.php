<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timelogs extends Model
{
    protected $fillable = [
        
    ];
    
     // Relation avec la conversation
     public function conversation()
     {
         return $this->belongsTo(Conversation::class, 'conversation_id');
     }


 
 
}
