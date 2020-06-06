<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    
    protected $fillable=["email", "name"];

    public function sales(){
        return $this->hasMany(Payment::class);
    }

}
