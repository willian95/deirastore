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

        $words = explode(' ',strtolower($request->search)); // coloco cada palabra en un espacio del array
        $wordsToDelete = array('de');

        $words = array_values(array_diff($words,$wordsToDelete)); // Elimino todas las coincidencias de las wordsToDelete
        $synonymousIndexes = [];

        $synonymous =[
            [
                "monitor",
                "monitores",
                "pantalla",
                "pantallas",
                "screen",
                "screens",
            ],
            [
                "televisores",
                "televisor",
                "tele",
                "tv"
            ],
            [
                "pc",
                "computador",
                "computadores",
                "computadora",
                "computadoras",
                "ordenador",
                "ordenadores"
            ],
            [
                "disco",
                "discos",
                "hdd",
                "hard drive",
                "drive"
            ],
            [
                "memoria",
                "memoria usb",
                "pendrive"
            ],
            [
                "lector",
                "lectores"
            ]
        ];

        $index = 0;
        for($i = 0; $i < count($words); $i++){ //se recorren las palabras extraidas

            foreach($synonymous as $sy){ // se recorren los sinonimos
                foreach($sy as $word){
                    if($word == $words[$i]){ //si la palabra de busqueda se encuentra entre los sinonimos
                        array_push($synonymousIndexes, $index); // se añade al array de los synoymousIndexes, esto con el fin de tomar todas las coincidencias de los sinonimos
                    }
                }
                $index++;
            }

        }

        for($i = 0; $i < count($synonymousIndexes); $i++){
            foreach($synonymous[$synonymousIndexes[$i]] as $word){ //recorremos todas las palabras dentro del indice
                array_push($words, $word); // añadimos las palabras al arreglo de palabras
            }
        }

        $words = array_unique($words); //eliminamos las palabras duplicadas
        $words = array_values($words); // reordenamos el array

        

        $products = Product::with('category')->select('products.name', 'products.is_external', "products.external_price", 'categories.name as category_name', "products.slug","products.picture", "products.price", "products.sub_price")->join('categories', 'products.category_id', '=', 'categories.id')->join('brands', 'products.brand_id','=', 'brands.id')
                    ->where(function ($query) use($words) {
                        for ($i = 0; $i < count($words); $i++){
                            $query->orWhere('products.name', $words[$i]);
                        }      
                    }) //Busco todas las coincidencias en el campo
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

        return view('search', ["products" => $products, "brands" => $brands, "categories" => $categories, "search" => $request->search]);

    }


}
