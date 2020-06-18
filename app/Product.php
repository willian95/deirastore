<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable=[
        "name",
        "price",	
        "sub_price",
        "picture",
        "sub_title",
        "description",
        "category_id",
        "created_at",
        "updated_at",
        "deleted_at",
        "amount",
        "slug",
        "sku",
        "vpn",
        "parent_nexsys",
        "data_source_id",
        "min_description",
        "product_type",
        "product_material",
        "dimenssions",
        "weight",
        "features",
        "location",
        "warranty",
        "color",
        "brand_id",
        "currency",
        "is_external",
        "tax_excluded",
        "external_price"
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function productPurchase(){
        return $this->hasMany(ProductPurchase::class);
    }

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function highlightedProduct(){
        return $this->hasMany(HighlightedProduct::class);
    }

}
