<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;

class HomeController extends Controller
{
    function index(){
        
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('home', ["products" => $products, "categories" => $categories, "brands" => $brands]);
    }

    function show($slug){

        $product = Product::where('slug', $slug)->first();

        return view('productDetail', ["product" => $product]);

    }

    function search(Request $request){


        $products = Product::with("category")->join('brands', 'products.brand_id', '=', 'brands.id')->where('products.name', 'like', '%'.$request->search.'%')->orWhere('products.sub_title', 'like', '%'.$request->search.'%')->orWhere('products.description', 'like', '%'.$request->search.'%')->orWhere("brands.name", 'like', '%'.$request->search.'%')->get();

        dd($products);

        $brands = Brand::where("name", "like", '%'.$request->search.'%')->get();

        $categories = Category::where('name', 'like', '%'.$request->search.'%')->get();

        return view('search', ["products" => $products, "brands" => $brands, "categories" => $categories]);

    }


}
