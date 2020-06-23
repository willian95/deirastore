<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\Category;
use App\BestCategory;
use App\BestStore;
use DB;
use App\Traits\CartAbandonTrait;

class HomeController extends Controller
{

    use CartAbandonTrait;

    function searchView(){
        return view("search");
    }

    function index(){
        
        //$products = Product::all();
        $this->sendMessage();
        $categories = BestCategory::all();
        $brands = BestStore::all();
        
        return view('home', ["categories" => $categories, "brands" => $brands]);
    }

    function show($slug){

        $this->sendMessage();

        $product = Product::where('slug', $slug)->with('items')->first();
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
        //dd($words);

        $brandInSearchText = "";
        $brandIdInSearchText = "";
        foreach(Brand::all() as $brand){
            foreach($words as $word){

                if(strtoupper($brand->name) == strtoupper($word)){
                    $brandInSearchText = $brand->name;
                    $brandIdInSearchText = $brand->id;
                }

            }
        }
        
        $searchText = strtolower(str_replace(strtoupper($brandInSearchText), "", strtoupper($request->search)));
        
        $skip = ($request->page-1) * 20;

        /*
        $products = Product::with("category")->join('categories', 'products.category_id', '=', 'categories.id')->join('brands', 'products.brand_id','=', 'brands.id')->where(function ($query) use($words) {
            for ($i = 0; $i < count($words); $i++){
                if($words[$i] != "")
                    $query->orWhere('description', "like", "%".$words[$i]."%");
            }      
        })->skip($skip)->take(20)->get();

        $productsCount = Product::with("category")->join('categories', 'products.category_id', '=', 'categories.id')->join('brands', 'products.brand_id','=', 'brands.id')->where(function ($query) use($words) {
            for ($i = 0; $i < count($words); $i++){
                if($words[$i] != "")
                    $query->orWhere('description', "like", "%".$words[$i]."%");
            }      
        })->count();
        */
        
        if($brandIdInSearchText != ""){
            
            $products = Product::where(function ($query) use($searchText) {
            
                $query->orWhere('description', "like", "%".$searchText."%");
                
            })->with("brand", "category")->where("brand_id", $brandIdInSearchText)->skip($skip)->take(20)->get();
    
            $productsCount = Product::where(function ($query) use($searchText) {
                
                $query->orWhere('description', "like", "%".$searchText."%");
                  
            })->with("brand", "category")->where("brand_id", $brandIdInSearchText)->count();
        
        }else{

            $products = Product::with("category", "brand")
            ->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('sku', "like", "%".$words[$i]."%");
                    }
                }      
            })
            ->skip($skip)->take(20)->orderBy("data_source_id")->orderBy("name")->get();
    
            $productsCount = Product::with("category", "brand")
            ->where(function ($query) use($words) {
                for ($i = 0; $i < count($words); $i++){
                    if($words[$i] != ""){
                        //$query->orWhere('description', "like", "%".$words[$i]."%");
                        $query->orWhere('name', "like", "%".$words[$i]."%");
                        $query->orWhere('sku', "like", "%".$words[$i]."%");
                    }
                }      
            })
            ->count();

        }
        
        //dd($products);

        return response()->json(["products" => $products, "productsCount" => $productsCount]);


    }


}
