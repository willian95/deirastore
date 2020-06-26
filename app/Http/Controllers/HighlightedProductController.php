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

    function userFetch(Request $request){

        try{

            $orderBy = "";
            if($request->filterOrder == 1){
                $orderBy = "name asc";
            }
            else if($request->filterOrder == 2){
                $orderBy = "name desc";
            }
            else if($request->filterOrder == 3){
                $orderBy = "case when percentage_range_profit >= 0 then price_range_profit else external_price end asc";
            }
            else if($request->filterOrder == 4){
                $orderBy = "case when percentage_range_profit >= 0 then price_range_profit else external_price end desc";
            }
            else if($request->filterOrder == 5){
                $orderBy = "amount asc";
            }
            else if($request->filterOrder == 6){
                $orderBy = "amount desc";
            }

            $skip = ($request->page-1) * 20;
            $products = HighlightedProduct::join("products", "products.id", '=', "highlighted_products.product_id")->with("product")->with('product.category')->with("product.brand")->skip($skip)->take(20)->orderByRaw($orderBy)->get();
            $productsCount = HighlightedProduct::with("product")->with('category')->with("brand")->count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
