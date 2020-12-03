<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;

class WishlistController extends Controller
{

    function index(){
        return view("wishlist");
    }
    
    function add(Request $request){

        try{

            $wish = new Wishlist;
            $wish->product_id = $request->productId;
            $wish->user_id = \Auth::user()->id;
            $wish->save();

            return response()->json(["success" => true, "msg" => "Producto añadido a tu lista de deseos"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function remove(Request $request){

        try{

            Wishlist::where("product_id", $request->productId)->where("user_id", \Auth::user()->id)->first()->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado de tu lista de deseos"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function checkProduct(Request $request){

        try{

            $wish = Wishlist::where("product_id", $request->productId)->where("user_id", \Auth::user()->id)->first();

            return response()->json(["success" => true, "wish" => $wish]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch(){

        try{

            $wishes = Wishlist::where("user_id", \Auth::user()->id)->with("product")->get();

            return response()->json(["success" => true, "wishes" => $wishes]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
