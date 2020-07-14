<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    
    protected $fillable=["email", "name"];

    public function sales(){
        return $this->hasMany(Payment::class);
    }

    public function location(){
        return $this->belongsTo(Region::class, "location_id");
    }

    public function commune(){
        return $this->belongsTo(Comune::class, "comune_id");
    }

}
