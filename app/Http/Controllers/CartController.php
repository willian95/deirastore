<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCart;
use App\Product;
use App\Cart;
use App\DolarPrice;

class CartController extends Controller
{
    function index(){
        return view('cart');
    }

    function getItems(){

        $carts = Cart::with("product", "product.brand")->where('user_id', \Auth::user()->id)->get();
        $total = Cart::where('user_id', \Auth::user()->id)->sum('price');

        return response()->json(["products" => $carts, "total" => $total]);

    }
    
    function store(StoreCart $request){

        try{

            if($this->userHasProduct($request->productId)){
                
                $product = Cart::where('user_id', \Auth::user()->id)->where('product_id', $request->productId)->first();
                $amount = $product->amount + $request->amount;
                $productModel = Product::find($request->product_id);
                if($productModel->external_price > 0)
                    $price = intval($productModel->external_price * DolarPrice::first()->price);
                else
                    $price = $productModel->price;

                if(!$this->verifyAmount($request->productId, $amount)){
                    return response()->json(["success" => false, "msg" => "Cantidad añadida supera a nuestro stock"]);
                }

                $product->amount = $amount;
                $product->price = $amount * $price;
                $product->update();
            
            }else{

                $cart = new Cart;
                $cart->product_id = $request->productId;
                $cart->amount = $request->amount;
                $cart->user_id = \Auth::user()->id;

                $productModel = Product::find($request->productId);
                if($productModel->external_price > 0)
                    $price = intval($productModel->external_price * DolarPrice::first()->price);
                else
                    $price = $productModel->price;

                $cart->price = $request->amount * $price;
                $cart->save();

            }

            return response()->json(["success" => true, "msg" => "Producto añadido al carrito"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

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

    function getGuestCarts(Request $request){
        
        $array = [];
        $cart = [];

        foreach($request->products as $product){
            array_push($array, $product["productId"]);
        }

        $products = Product::with('category', 'brand', "secondaryPictures")->whereIn('id', $array)->get();
        $loop = 0;
        $total = 0;

        foreach($products as $product){
            $price = 0;
            if($product->external_price > 0 && $product->price == 0){
                $price = $product->external_price * DolarPrice::first()->price;
            }else if($product->price > 0){
                $price = $product->price;
            }

            $total += $price;
            $picture = "";

            if($product->data_source_id == 2){

                $picture = $product->secondaryPictures[0]["image"];

            }else if($product->data_source_id == 1){

                $picture = $product->picture;

            }else{

                $picture = asset('/images/products/'.$product->picture);

            }

            $cart[] = [
                "id" => $product->id,
                "picture" => $picture,
                "name" => $product->name,
                "brand_image" => $product->brand->image,
                "brand_name" => $product->brand->name,
                "sub_title" => $product->sub_title,
                "price" => intval($price),
                "amount" => $request->products[$loop]["amount"],
                "is_external" => $product->is_external
            ];

            $loop++;

        }

        return response()->json(["cart" => $cart, "total" => $total]);

    }

}
