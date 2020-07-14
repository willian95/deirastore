<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table="regions";

    public function users(){
        return $this->hasMany(User::class, "location_id");
    }
}
