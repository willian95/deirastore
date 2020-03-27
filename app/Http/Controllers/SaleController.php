<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;

class SaleController extends Controller
{
    
    function index(){

        return view('admin.sale');

    }

    function fetch(Request $request){
        try{

            $skip = ($request->page-1) * 10;

            $sales = Payment::with('user')->with('productPurchase')->with('productPurchase.product')->skip($skip)->take(10)->get();
            $salesCount = Payment::with('user')->with('productPurchase')->with('productPurchase.product')->count();

            return response()->json(["success" => true, "sales" => $sales, "salesCount" => $salesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }
    }

}
