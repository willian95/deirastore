<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function productPurchase(){
        return $this->hasMany(ProductPurchase::class);
    }

    function brand(){
        return $this->belongsTo('App\Brand');
    }

}
