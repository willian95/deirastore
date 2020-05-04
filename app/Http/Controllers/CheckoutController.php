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
use DB;

class CheckoutController extends Controller
{
    public function initTransaction(WebpayNormal $webpayNormal, Request $request)
	{
		//dd($request->all());
		if($request->has("cart")){ // si el usuario es invitado
			session(["cart" => $request->cart, "email" => $request->email, "name" => $request->name]);
			$products = json_decode($request->cart);
			$total = 0;

			foreach($products as $product){
				
				$val = Product::find($product->productId);

				if($val->external_price > 0 && $val->price == 0){ //si el precio externo es mayor a 0 y precio es igual 0
					$total += intval($val->external_price * DolarPrice::first()->price);
				}else{
					$total += intval($val->price);
				}

			}
			
		}else{ // si el usuario está registrado
			$carts = Cart::with('product')->where('user_id', \Auth::user()->id)->get();
			$total = Cart::where('user_id', \Auth::user()->id)->sum('price');
		}

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
		
		$response = session('response'); // obtenemos la respuesta de webpay
		//dd();

		$this->checkout($response->detailOutput->responseCode);
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

				$email = session('email');
				$guest = Guest::where("email", $email)->first();
				$payment->guest_id = $guest->id; // añadimos el id de invitado
			
			}

			$payment->save();
			
			if($responseCode == 0){
				//dd(\Auth::check());
				if(\Auth::check()){ // si está logueado
					$carts = Cart::with('product')->where('user_id', \Auth::user()->id)->get(); 
					foreach($carts as $cart){

						$productPurchase = new ProductPurchase; //creamos un nuevo producto comprado
						$productPurchase->user_id = \Auth::user()->id; // añadimos el id de usuario
						$productPurchase->payment_id = $payment->id;// añadimos el id de pago
						$productPurchase->product_id = $cart->product_id; // añadimos el id de producto
						$productPurchase->amount = $cart->amount; // añadimos la cantidad
						
						$productPurchase->price = $cart->price; // añadimos el prcio
						$productPurchase->save(); // guardamos
		
						$product = Product::find($cart->product_id);
						$product->amount = $product->amount - $cart->amount; // descontamos del inventario
						$product->update();
		
					}
		
					$carts = Cart::where('user_id', \Auth::user()->id)->delete(); // borramos los productos de la tabla cart
				
				}else{ // si el usuario es invitado
					
					$carts = json_decode(session("cart")); //obtenemos los productos de la sesión
					
					$email = session('email');
					$guest = Guest::where("email", $email)->first(); //obtenemos el id de invitado
					
					foreach($carts as $cart){

						$product = Product::find($cart->productId);
						
						$productPurchase = new ProductPurchase;
						$productPurchase->guest_id = $guest->id;
						$productPurchase->payment_id = $payment->id;
						$productPurchase->product_id = $cart->productId;
						$productPurchase->amount = $cart->amount;
						
						if($product->external_price > 0 && $product->price == 0){ //si el producto cuenta con precio externo mayor a 0 y precio = 0
							$productPurchase->price = intval($product->external_price * DolarPrice::first()->price); //multiplica el precio en USD por el valor en CLP
						}else{	
							$productPurchase->price = $product->price;
						}
						
						//dd($productPurchase);

						$productPurchase->save();
		
						$product->amount = $product->amount - $cart->amount; // descontamos del inventario
						$product->update();
		
					}

				}
				
				//dd("finalizar");
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

}
