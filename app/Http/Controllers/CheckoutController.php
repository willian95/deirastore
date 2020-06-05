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
use App\Guest;
use App\DolarPrice;
use App\Shipping;
use DB;

class CheckoutController extends Controller
{
    public function initTransaction(WebpayNormal $webpayNormal)
	{
		//dd($request->all());
		$carts = session("cart");
		$total = 0;
		foreach($carts as $cart){

			$total = $total + ($cart["price"] * $cart["amount"]) + $cart["shipping_cost"];

		}

		$order = Carbon::now()->timestamp.uniqid();
		session(['order' =>$order]);

		$webpayNormal->addTransactionDetail(intval($total), $order);  
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
		
		$response = session('response'); // obtenemos la respuesta de webpay
		//dd();

		//$this->checkout($response->detailOutput->responseCode);
		$carts = session("cart"); //obtenemos los productos de la sesión
		//dd($carts);
		foreach($carts as $cart){
			dd($cart);
		}
		
		if($response->detailOutput->responseCode == 0){

			$payment = Payment::where('order_id', session('order'))->first(); //obtenemos el pago registrado en la funcion checkout
			$products = ProductPurchase::with('product')->where('payment_id', $payment->id)->get();
			$this->sendMessage($products);
			$name = "";
			if(\Auth::guest()){

				$name = session('name');
				session()->forget(["cart", "email", "name", "response"]);
				session()->flush();
				session()->save();

			}
			

			return view('successPayment', ["products" => $products, "name" => $name]);
		}else{
			return view('failedPayment');
		}

	  // Acá buscar la transacción en tu base de datos y ver si fue exitosa o fallida, para mostrar el mensaje de gracias o de error según corresponda
	}

	function checkout($responseCode){

		try{

		
			$payment = new Payment; // creamos un nuevo pago
			$payment->order_id = session('order');

			if($responseCode == 0){ // si la respuesta de webpay es 0
				$payment->status = "aprovado";
			}
			else{
				$payment->status = "rechazado";
			}
			
			if(\Auth::check()){ //si el usuario está logueado
				$payment->user_id = \Auth::user()->id; // añadimos el id de usuario
			}
			
			else{//si no está loguestado
				$payment->guest_id = session('guestUser'); // añadimos el id de invitado
			
			}

			$payment->save();
			
			if($responseCode == 0){
				//dd(\Auth::check());
				
					
					$carts = json_decode(session("cart")); //obtenemos los productos de la sesión
					
					foreach($carts as $cart){

						$product = Product::find($cart->productId);
						
						$productPurchase = new ProductPurchase;
						if(\Auth::check()){
							$productPurchase->user_id = \Auth::user()->id;
						}else{
							$productPurchase->guest_id = session('guestUser');
						}
						
						$productPurchase->payment_id = $payment->id;
						$productPurchase->product_id = $cart->productId;
						$productPurchase->amount = $cart->amount;
						
						if($product->external_price > 0 && $product->price == 0){ //si el producto cuenta con precio externo mayor a 0 y precio = 0
							$productPurchase->price = intval(($product->external_price * DolarPrice::first()->price) * $cart->amount); //multiplica el precio en USD por el valor en CLP
						}else{	
							$productPurchase->price = $product->price * $cart->amount;
						}
						
						//dd($productPurchase);

						$productPurchase->save();
		
						$product->amount = $product->amount - $cart->amount; // descontamos del inventario
						$product->update();
		
					}

			}


		}catch(\Exception $e){
			//dd($e);
			return redirect()->to('cart');

		}

	}

	function sendMessage($products){

        try{

			if(\Auth::check()){ // si está logueado
				
				$to_name = \Auth::user()->name; // nombre de usuario logueado
				$to_email = \Auth::user()->email;// email de usuario logueado
				$user = User::find(\Auth::user()->id);// obtenemos todos los datos del usuario logueado
			
			}else{// si es invitado

				$to_name = session("name");// nombre de usuario invitado
				$to_email = session("email");// email de usuario invitado
				$user = User::where("email", $to_email)->first();// obtenemos todos los datos del usuario invitado

			}
			
			$data = ["user" => $user, "products" => $products];
			\Mail::send("emails.purchaseMail", $data, function($message) use ($to_name, $to_email) {// se envía el email

				$message->to($to_email, $to_name)->subject("¡Tu compra se ha realizado con éxito!");
				$message->from("rodriguezwillian95@gmail.com","Deira");

			});


        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

		}
	}

	function storeSession(Request $request){

		try{

			$guestUserId =  0;
			session(["cart" => $request->items, "type" => $request->type]);
			if(isset($request->guestUser)){

				if(!Guest::where("rut", $request->guestUser["rut"])->first()){

					$guest = new Guest;
					$guest->name = $request->guestUser["name"];
					$guest->email = $request->guestUser["guestEmail"];
					$guest->lastname = $request->guestUser["lastname"];
					$guest->phone = $request->guestUser["phoneNumber"];
					$guest->rut = $request->guestUser["rut"];
					$guest->location_id = $request->guestUser["location_id"];
					$guest->comune_id = $request->guestUser["comune_id"];
					$guest->street = $request->guestUser["street"];
					$guest->number = $request->guestUser["number"];
					$guest->house = $request->guestUser["house"];
					$guest->save();

					$guestUserId = $guest->id;

				}else{
					session(["guestUser" => Guest::where("rut", $request->guestUser["rut"])->first()->id]);
				}

			}else{
				session(["user" => \Auth::user()->id]);
			}

			return response()->json(["success" => true, "guestUserId" => $guestUserId]);

		}catch(\Exception $e){
			return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);
		}
		
	}

}
