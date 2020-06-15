<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GuestStoreRequest;
use App\Guest;
use App\Product;
use App\DolarPrice;
use App\Shipping;

class GuestController extends Controller
{
    
    function guestCheckoutIndex(){
        return view('guestCheckout');
    }

    function store(GuestStoreRequest $request){

        try{

            Guest::updateOrCreate(
                ["email" => $request->email],
                ["name" => $request->name]
            );

            return response()->json(["success" => true]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function cartPrices(Request $request){
        
        $total = 0;
        $totalWeight = 0;
        foreach($request->products as $product){
            
            $products = Product::with('category', 'brand', "items")->where('id', $product["productId"])->first();

            $price = 0;
            if($products->external_price > 0 && $products->price == 0){
                $price = (($products->external_price * DolarPrice::first()->price)) * $product["amount"];
            }else if($products->price > 0){
                $price = $products->price * $product["amount"];
            }

            $total += $price;

            foreach($products->items as $item){
                    
                if($item->name == "Peso"){
                    
                    $parts = explode(" ", $item->description);
                    $weight = $parts[0];
                    if($parts[1] == "g"){
                        $weight = $parts[0] / 1000;
                    }
                    $totalWeight = ($totalWeight + $weight) * $product["amount"];

                }

            }

        }

        $shippingCost = 0;

        if(isset($request->location)){
            $shipping = Shipping::where('location_id', $request->location)->where("min_weight", "<=", $totalWeight)->where("max_weight", ">=", $totalWeight)->first();
            $shippingCost = $shipping->price * $totalWeight;
        }

        return response()->json(["total" => $total, "shippingCost" => $shippingCost]);

    }

    function getGuestUser(Request $request){

        try{

            $guest = Guest::where("id", $request->id)->first();
            return response()->json(["guest" => $guest]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
