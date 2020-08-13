<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SalesExport;
use App\Payment;
use Excel;

class SaleController extends Controller
{
    
    function index(){

        return view('admin.sale');

    }

    function fetch(Request $request){
        try{

            $skip = ($request->page-1) * 10;

            $sales = Payment::with('user', 'guest', 'productPurchase', 'productPurchase.product', "user.location", "user.commune", "guest.location", "guest.commune")->has('productPurchase')->skip($skip)->take(10)->orderBy('id', 'desc')->get();
            $salesCount = Payment::with('productPurchase')->with('productPurchase.product')->count();

            return response()->json(["success" => true, "sales" => $sales, "salesCount" => $salesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }
    }

    function export($fromDate, $toDate){

        try{

            return Excel::download((new SalesExport)->forFromDate($fromDate)->forToDate($toDate), 'ventas'.$fromDate.'-'.$toDate.'.xlsx');

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);
        }

    }

}
