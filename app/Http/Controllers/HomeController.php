<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Brand;
use DB;

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

        $words = explode(' ',$request->search);
        $wordsToDelete = array('de');

        $words = array_values(array_diff($words,$wordsToDelete));
        
        //DB::statement('ALTER TABLE products ADD FULLTEXT fulltext_index (name, description)');
        //$products = Product::where('name', 'like', '%'.$request->search.'%')->get();

        $products = Product::with('category')->join('categories', 'products.category_id', '=', 'categories.id')->join('brands', 'products.brand_id','=', 'brands.id')
                    ->where(function ($query) use($words) {
                        for ($i = 0; $i < count($words); $i++){
                            $query->orWhere('products.name', $words[$i]);
                        }      
                    })
                    ->orWhere(function ($query) use($words) {
                        for ($i = 0; $i < count($words); $i++){
                            $query->orWhere('categories.name', 'like',  '%' . $words[$i] .'%');
                        }      
                    })
                    ->orWhere(function ($query) use($words) {
                        for ($i = 0; $i < count($words); $i++){
                        $query->orwhere('products.description', 'like', '%'.$words[$i].'%');
                        }      
                    })
                    ->orWhere(function ($query) use($words) {
                        for ($i = 0; $i < count($words); $i++){
                        $query->orwhere('products.sub_title', $words[$i]);
                        }      
                    })
                    ->orWhere(function ($query) use($words) {
                        for ($i = 0; $i < count($words); $i++){
                        $query->orwhere('brands.name', 'like',  '%' . $words[$i] .'%');
                        }      
                    })
                    ->get();

        $brands = Brand::where(function ($query) use($words) {
            for ($i = 0; $i < count($words); $i++){
                $query->orWhere('brands.name', 'like',  '%' . $words[$i] .'%');
            }      
        })->get();

        $categories = Category::where(function ($query) use($words) {
            for ($i = 0; $i < count($words); $i++){
                $query->orWhere('categories.name', 'like',  '%' . $words[$i] .'%');
            }      
        })->get();

        return view('search', ["products" => $products, "brands" => $brands, "categories" => $categories]);

    }


}
