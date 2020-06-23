<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HighlightedProduct;
use App\Http\Requests\HighlightedProductStore;
use App\Product;

class HighlightedProductController extends Controller
{
    
    function index(){

        return view("admin.highlightedProducts");

    }

    function search(Request $request){

        try{

            $products = $products = Product::with("category", "brand")
            ->where(function ($query) use($request) {
            
                //$query->orWhere('description', "like", "%".$words[$i]."%");
                $query->orWhere('name', "like", "%".$request->search."%");
                $query->orWhere('sku', "like", "%".$request->search."%");
                        
            })->take(50)->get();
            return response()->json(["success" => true, "products" => $products]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function store(HighlightedProductStore $request){

        try{

            $highlightedProduct = new HighlightedProduct;
            $highlightedProduct->product_id = $request->product;
            $highlightedProduct->save();

            return response()->json(["success" => true, "msg" => "Productos destacado creado"]);
        
        }catch(\Exception $e){
        
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]); 
        
        }

    }

    public function delete(Request $request){

        try{

            HighlightedProduct::where("id", $request->id)->delete();
            return response()->json(["success" => true, "msg" => "Producto destacado eliminada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function fetch(){

        try{

            $highlightedProduct = HighlightedProduct::with("product")->get();
            return response()->json(["success" => true, "highlightedProduct" => $highlightedProduct]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
