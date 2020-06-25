<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCart;
use App\Product;
use App\Cart;
use App\DolarPrice;
use App\Shipping;
use App\User;

class CartController extends Controller
{
    function index(){
        return view('cart');
    }

    function getItems(){

        $carts = Cart::with("product", "product.brand", "product.items")->where('user_id', \Auth::user()->id)->get();
        $total = Cart::where('user_id', \Auth::user()->id)->sum('price');
        $shippingCost = Cart::where('user_id', \Auth::user()->id)->sum('shipping_price');
        $shippingProductAmount = Cart::where("user_id",\Auth::user()->id)->where("shipping_method", 2)->count();
        $cartProductAmount = Cart::where("user_id",\Auth::user()->id)->count();

        return response()->json(["products" => $carts, "total" => $total, "shippingCost" => $shippingCost, "shippingAmount" => $shippingProductAmount, "cartCount" => $cartProductAmount]);

    }
    
    function store(StoreCart $request){

        try{

            if($this->userHasProduct($request->productId)){
                
                $product = Cart::where('user_id', \Auth::user()->id)->where('product_id', $request->productId)->first();
                $amount = $product->amount + $request->amount;
                $productModel = Product::find($request->productId);
                if($productModel->external_price > 0)
                    $price = intval($productModel->external_price * DolarPrice::first()->price) + 1;
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
                    $price = intval($productModel->external_price * DolarPrice::first()->price) + 1;
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
            if($products->percentage_range_profit > 0 && $products->percentage_range_profit != null){
                $price = (($products->price_range_profit * DolarPrice::first()->price) ) * $product["amount"];
            }else{
                $price = (($products->external_price * DolarPrice::first()->price) ) * $product["amount"];
            }
            $picture = "";

            if($products->data_source_id == 2){

                $picture = $products->picture;

            }else if($products->data_source_id == 1){

                $picture = $products->picture;

            }else{

                $picture = asset('/images/products/'.$products->picture);

            }

            $individualPrice =0;
            if($products->percentage_range_profit > 0 && $products->percentage_range_profit != null){
                $individualPrice = ($products->price_range_profit * DolarPrice::first()->price) + 1;
            }else{
                $individualPrice = ($products->external_price * DolarPrice::first()->price) + 1;
            }

            $total += $individualPrice * $product["amount"];

            $cart[] = [
                "id" => $product["productId"],
                "picture" => $picture,
                "name" => $products->name,
                "brand_image" => $products->brand->image,
                "brand_name" => $products->brand->name,
                "sub_title" => $products->sub_title,
                "price" => intval($individualPrice),
                "amount" => $request->products[$loop]["amount"],
                "is_external" => $products->is_external,
                "data_source_id" => $products->data_source_id
            ];

            $loop++;

        }

        return response()->json(["cart" => $cart, "total" => $total]);

    }

    function updateShippingPrice(Request $request){

        try{
            $loop = 0;
            foreach($request->products as $product){
                $products = Product::with('category', 'brand', "items")->where('id', $product['id'])->first();
            
                $price = 0;
                if($products->percentage_range_profit > 0 && $products->percentage_range_profit != null){
                    $price = (($products->price_range_profit * DolarPrice::first()->price) ) * $product["amount"];
                }else{
                    $price = (($products->external_price * DolarPrice::first()->price) ) * $product["amount"];
                }
    
                $picture = "";
    
                if($products->data_source_id == 2){
    
                    $picture = $products->picture;
    
                }else if($products->data_source_id == 1){
    
                    $picture = $products->picture;
    
                }else{
    
                    $picture = asset('/images/products/'.$products->picture);
    
                }
    
                $individualPrice =0;
                if($products->percentage_range_profit > 0 && $products->percentage_range_profit != null){
                    $individualPrice = ($products->price_range_profit * DolarPrice::first()->price) + 1;
                }else{
                    $individualPrice = ($products->external_price * DolarPrice::first()->price) + 1;
                }
    
                //$total += $individualPrice * $product["amount"];

                $shippingMethod = "1";

                foreach($request->shippingChoices as $choice){

                    if($choice["id"] == $product['id']){
                        $shippingMethod = $choice["shippingMethod"];
                    }

                }

                $shippingCost = 0;
                if(isset($request->location_id)){

                    if($shippingMethod == 2){

                        $totalWeight = 0;
                    
                        $productModel = Product::with("category")->where('id', $product["id"])->first();
                        if($productModel->category){
                            $totalWeight = $productModel->category->weight * $product["amount"];
                            $shipping = Shipping::where('location_id', $request->location)->where("min_weight", "<=", $totalWeight)->where("max_weight", ">=", $totalWeight)->first();
                            $shippingCost = $shipping->price * $totalWeight;
                            
                        }
    
                    }

                }
    
                $cart[] = [
                    "id" => $product["id"],
                    "picture" => $picture,
                    "name" => $products->name,
                    "brand_image" => $products->brand->image,
                    "brand_name" => $products->brand->name,
                    "sub_title" => $products->sub_title,
                    "price" => intval($individualPrice),
                    "amount" => $request->products[$loop]["amount"],
                    "is_external" => $products->is_external,
                    "data_source_id" => $products->data_source_id,
                    "shipping_method" => $shippingMethod,
                    "shipping_cost" => $shippingCost
                ];
    
                $loop++;
    
            }
    
    
    
            return response()->json(["cart" => $cart]);



        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function updateCartLocation(Request $request){



            foreach($request->products as $product){

                $shippingCost = 0;
                if($product["shipping_method"] == 2){

                    $totalWeight = 0;
                
                    $productModel = Product::with("category")->where('id', $product["id"])->first();
                    if($productModel->category){
                        $totalWeight = $productModel->category->weight * $product["amount"];
                        $shipping = Shipping::where('location_id', $request->location)->where("min_weight", "<=", $totalWeight)->where("max_weight", ">=", $totalWeight)->first();
                        $shippingCost = $shipping->price * $totalWeight;
                        
                    }

                }
    
                $cart[] = [
                    "id" => $product["id"],
                    "picture" => $product["picture"],
                    "name" => $product["name"],
                    "brand_image" => $product["brand_image"],
                    "brand_name" => $product["brand_name"],
                    "sub_title" => $product["sub_title"],
                    "price" => $product["price"],
                    "amount" => $product["amount"],
                    "is_external" => $product["is_external"],
                    "data_source_id" => $product["data_source_id"],
                    "shipping_method" => $product["shipping_method"],
                    "shipping_cost" => $shippingCost
                ];

            }

        return response()->json(["success" => true, "cart" => $cart]);

    }

    function billType(Request $request){

        try{

            Cart::where("user_id", \Auth::user()->id)->update(["bill_type" => $request->billType]);

            return response()->json(["success" => true]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }
    
    function cartShippingView(){
        return view("cartShipping");
    }


}
