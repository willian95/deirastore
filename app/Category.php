<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable =[
        "name", "slug", "image", "parent_id", "esp_name", "length", "width", "height", "weight_unit", "dimenssions_unit"
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function child(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function bestCategories(){
        return $this->hasMany(BestCategory::class);
    }

}
