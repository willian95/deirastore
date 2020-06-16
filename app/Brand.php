<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    
    protected $fillable=[
        "name", "image", "slug"
    ];

    function products(){
        return $this->hasMany('App\Product');
    }

    function bestStores(){
        return $this->belongsTo(BestStore::class);
    }

}
