<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    public function payment(){
        return $this->hasMany(Payment::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


}
