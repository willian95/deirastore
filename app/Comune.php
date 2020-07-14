<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comune extends Model
{
    protected $table = "communes";

    public function users(){
        return $this->hasMany(User::class, "comune_id");
    }

    public function guests(){
        return $this->hasMany(Guest::class, "location_id");
    }

}
