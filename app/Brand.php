<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    
    function products(){
        return $this->hasMany('App\Product');
    }

}
