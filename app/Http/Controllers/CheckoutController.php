<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Freshwork\Transbank\WebpayNormal;
use Freshwork\Transbank\WebpayPatPass;
use Freshwork\Transbank\RedirectorHelper;
use Carbon\Carbon;
use App\Cart;
use App\ProductPurchase;
use App\Payment;
use App\Product;
use App\User;
use DB;

class CheckoutController extends Controller
{
    public function initTransaction(WebpayNormal $webpayNormal)
	{
		
		$carts = Cart::with('product')->where('user_id', \Auth::user()->id)->get();
		$total = Cart::where('user_id', \Auth::user()->id)->sum('price');

		$order = Carbon::now()->timestamp.uniqid();
		session(['order' =>$order]);

		$webpayNormal->addTransactionDetail($total, $order);  
		$response = $webpayNormal->initTransaction(route('checkout.webpay.response'), route('checkout.webpay.finish'), null, 'TR_NORMAL_WS', null, null); 
		// Probablemente también quieras crear una orden o transacción en tu base de datos y guardar el token ahí.

		return RedirectorHelper::redirectHTML($response->url, $response->token);
    }
    
    public function response(WebpayPatPass $webpayPatPass)  
	{  
	  	$result = $webpayPatPass->getTransactionResult();    
		session(['response' => $result]);  

		$webpayPatPass->acknowledgeTransaction();

	  	// Revisar si la transacción fue exitosa ($result->detailOutput->responseCode === 0) o fallida para guardar ese resultado en tu base de datos. 
	  	//return RedirectorHelper::redirectBackNormal($result->urlRedirection);
	  	return RedirectorHelper::redirectBackNormal($result->urlRedirection);  
	}

	public function finish()  
	{
		//dd($_POST, session('response')); 
		
		$response = session('response');
		//dd();

		$this->checkout($response->detailOutput->responseCode);
		if($response->detailOutput->responseCode == 0){

			$payment = Payment::where('order_id', session('order'))->first();
			$products = ProductPurchase::with('product')->where('payment_id', $payment->id)->get();

			return view('successPayment', ["products" => $products]);
		}else{
			return view('failedPayment');
		}

	  // Acá buscar la transacción en tu base de datos y ver si fue exitosa o fallida, para mostrar el mensaje de gracias o de error según corresponda
	}

	function checkout($responseCode){

		try{

			$carts = Cart::where('user_id', \Auth::user()->id)->get();

			$payment = new Payment;
			$payment->order_id = session('order');
			if($responseCode == 0)
				$payment->status = "aprovado";
			else
				$payment->status = "rechazado";
			$payment->user_id = \Auth::user()->id;
			$payment->save();

			if($responseCode == 0){

				foreach($carts as $cart){

					$productPurchase = new ProductPurchase;
					$productPurchase->user_id = \Auth::user()->id;
					$productPurchase->payment_id = $payment->id;
					$productPurchase->product_id = $cart->product_id;
					$productPurchase->amount = $cart->amount;
					$productPurchase->price = $cart->price;
					$productPurchase->save();
	
					$product = Product::find($cart->product_id);
					$product->amount = $product->amount - $cart->amount;
					$product->update();
	
				}
	
				$carts = Cart::where('user_id', \Auth::user()->id)->delete();

			}

		}catch(\Exception $e){

			return redirect()->to('cart');

		}

	}

	function sendMessage(){

        try{

			$to_name = \Auth::user()->name;
			$to_email = \Auth::user()->email;
			$user = User::find(\Auth::user()->id);

			$data = ["user" => $user];
			\Mail::send("emails.recoveryMail", $data, function($message) use ($to_name, $to_email) {

				$message->to($to_email, $to_name)->subject("Deira");
				$message->from("rodriguezwillian95@gmail.com","Deira");

			});


        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

		}
	}

}
