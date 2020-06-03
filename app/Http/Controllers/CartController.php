<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCart;
use App\Product;
use App\Cart;
use App\DolarPrice;
use App\Shipping;

class CartController extends Controller
{
    function index(){
        return view('cart');
    }

    function getItems(){

        $carts = Cart::with("product", "product.brand", "product.items")->where('user_id', \Auth::user()->id)->get();
        $total = Cart::where('user_id', \Auth::user()->id)->sum('price');
        /*$shippingCost = 0;
        $totalWeight = 0;

        foreach($carts as $cart){

            if($cart->product != null){

                if($cart->product->items){
                    
                    foreach($cart->product->items as $item){
                        
                        if($item->name == "Peso"){
                            
                            $parts = explode(" ", $item->description);
                            $weight = $parts[0];
                            if($parts[1] == "g"){
                                $weight = $parts[0] / 1000;
                            }
                            $totalWeight = ($totalWeight + $weight) * $cart->amount;

                        }

                    }

                }

            }

        }

        $shipping = Shipping::where('location_id', \Auth::user()->location_id)->where("min_weight", "<=", $totalWeight)->where("max_weight", ">=", $totalWeight)->first();
        $shippingCost = $shipping->price * $totalWeight;*/

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
        $loop = 0;
        $total = 0;
        $totalWeight = 0;

        foreach($request->products as $product){
            $products = Product::with('category', 'brand', "items")->where('id', $product['productId'])->first();
        
            $price = 0;
            if($products->external_price > 0 && $products->price == 0){
                $price = ($products->external_price * DolarPrice::first()->price) * $product["amount"];
            }else if($products->price > 0){
                $price = $products->price * $product["amount"];
            }

            $total += $price;
            $picture = "";

            if($products->data_source_id == 2){

                $picture = $products->picture;

            }else if($products->data_source_id == 1){

                $picture = $products->picture;

            }else{

                $picture = asset('/images/products/'.$products->picture);

            }

            $individualPrice =0;
            if($products->external_price > 0 && $products->price == 0){
                $individualPrice = ($products->external_price * DolarPrice::first()->price);
            }else if($products->price > 0){
                $individualPrice = $products->price;
            }

            $cart[] = [
                "id" => $product["productId"],
                "picture" => $picture,
                "name" => $products->name,
                "brand_image" => $products->brand->image,
                "brand_name" => $products->brand->name,
                "sub_title" => $products->sub_title,
                "price" => intval($individualPrice),
                "amount" => $request->products[$loop]["amount"],
                "is_external" => $products->is_external
            ];

            $loop++;

        }



        return response()->json(["cart" => $cart, "total" => $total]);

    }

    

}
