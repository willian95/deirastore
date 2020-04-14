<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCart;
use App\Product;
use App\Cart;

class CartController extends Controller
{
    function index(){
        return view('cart');
    }

    function getItems(){

        $carts = Cart::with("product", "product.brand")->where('user_id', \Auth::user()->id)->get();
        $total = 0;
        foreach($carts as $cart){

            $total += $cart->amount * $cart->product->price;

        }

        return response()->json(["products" => $carts, "total" => $total]);

    }
    
    function store(StoreCart $request){

        try{

            if($this->userHasProduct($request->productId)){
                
                $product = Cart::where('user_id', \Auth::user()->id)->where('product_id', $request->productId)->first();
                $amount = $product->amount + $request->amount;

                if(!$this->verifyAmount($request->productId, $amount)){
                    return response()->json(["success" => false, "msg" => "Cantidad aadida supera a nuestro stock"]);
                }

                $product->amount = $amount;
                $product->update();
            
            }else{

                $cart = new Cart;
                $cart->product_id = $request->productId;
                $cart->amount = $request->amount;
                $cart->user_id = \Auth::user()->id;
                $cart->save();

            }

            return response()->json(["success" => true, "msg" => "Producto añadido al carrito"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }

    }
    
    function update(Request $request){

        try{

            $cart = Cart::find($request->id);
            $cart->amount = $request->amount;
            $cart->update();

            return response()->json(["success" => true, "msg" => "Carrito actualizado"]);

        }catch(\Exception $e){
            
            return response()->json(["success" => false, "msg" => "error en el servidor"]);
        
        }

    }

    function userHasProduct($productId){

        $exists = false;

        if(Cart::where('user_id', \Auth::user()->id)->where('product_id', $productId)->count() > 0){
            $exists = true;
        }

        return $exists;

    }

    function verifyAmount($productId, $cartAmount){

        $approved = true;

        $product = Product::find($productId);
        $amount = $product->amount;

        if($cartAmount > $amount){
            $approved = false;
        }

        return $approved;

    }

    function delete(Request $request){

        try{

            $cart = Cart::find($request->id);
            $cart->delete();

            return response()->json(["success" => true, "msg" => "Articulo eliminado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "error en el servidor"]);
        }

    }

}
