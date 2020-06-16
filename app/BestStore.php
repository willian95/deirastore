<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestStore extends Model
{
    
    function brand(){
        return $this->belongsTo(Brand::class);
    }

}
