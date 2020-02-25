<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    function index(){
        
        $products = Product::all();
        
        return view('home', ["products" => $products]);
    }

    function show($slug){

        $product = Product::where('slug', $slug)->first();

        return view('productDetail', ["product" => $product]);

    }


}
