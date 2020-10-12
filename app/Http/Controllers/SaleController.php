<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SalesExport;
use App\Payment;
use App\ProductPurchase;
use Excel;
use App\User;

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

    function pickup(Request $request){

        $payment = Payment::find($request->id);
        $payment->ready_to_pickup = 1;
        $payment->update();

        $user = User::find($payment->user_id);

        $products = ProductPurchase::with('product')->where('payment_id', $payment->id)->where("shipping_method", "retiro")->get();

        if(count($products) <= 0){
            return response()->json(["success" => false, "msg" => "No hay productos para retirar"]);
        }

        $data = ["title" => "Ya puedes retirar tus productos", "text" => "Tus productos ya están listos para ser retirados en la tienda.", "products" => $products];
        $to_name = $user->name;
        $to_email = $user->email;
        \Mail::send("emails.shippingMail", $data, function($message) use ($to_name, $to_email) {

            $message->to($to_email, $to_name)->subject("¡Ya puedes retirar tus productos!");
            $message->from(env("MAIL_FROM_ADDRESS"),"Deira");

        });


        return response()->json(["success" => true, "msg" => "Se ha notificado al cliente el retiro de los articulos"]);

    }

}
