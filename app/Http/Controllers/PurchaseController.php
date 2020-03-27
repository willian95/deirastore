<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePurchase;
use App\Product;
use App\Purchase;
use App\Payment;

class PurchaseController extends Controller
{
    
    function index(){

        return view('admin.purchaseProducts');

    }

    function show($id){

        return view('admin.purchases', ['id' => $id]);

    }

    function myPurchase(){

        return view('purchase');

    }

    function myPurchaseFetch(Request $request){

        try{

            $skip = ($request->page-1) * 10;

            $purchases = Payment::where('user_id', \Auth::user()->id)->with('user')->with('productPurchase')->with('productPurchase.product')->skip($skip)->take(10)->get();
            $purchasesCount = Payment::where('user_id', \Auth::user()->id)->with('user')->with('productPurchase')->with('productPurchase.product')->count();

            return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }

    }

    function fetch(Request $request){
        try{

            $skip = ($request->page-1) * 10;

            $purchases = Purchase::where('product_id', $request->productId)->skip($skip)->take(10)->get();
            $purchasesCount = Purchase::where('product_id', $request->productId)->count();

            return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }
    }

    function store(StorePurchase $request){

        try{

            $purchase = new Purchase;
            $purchase->product_id = $request->productId;
            $purchase->shopping_price = $request->shoppingPrice;
            $purchase->amount = $request->amount;
            $purchase->save();

            $product = Product::find($request->productId);
            $amount = $product->amount + $request->amount; 
            $product->amount = $amount;
            $product->update();

            return response()->json(["success" => true, "msg" => "Compra registrada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function delete(Request $request){

        try{

            $purchase = Purchase::find($request->purchaseId);
            $product = Product::find($purchase->product_id);
            $amount = $product->amount - $purchase->amount;
            $product->amount = $amount;
            $product->update();
            $purchase->delete();

            return response()->json(["success" => true, "msg" => "Compra eliminada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "error" => $e->getMessage()]);

        }

    }

}
