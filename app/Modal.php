<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    protected $fillable = ["id", "status", "text", "image"];
}
