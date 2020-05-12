<?php 
namespace App\Traits;

use App\Cart;

trait CartAbandonTrait
{
    public function sendMessage()
    {
        if(\Auth::check() && url()->previous() == url('/cart')){
            $products = Cart::with('product')->where('user_id', \Auth::user()->id)->get();
            $data = ["products" => $products];
            $to_email = \Auth::user()->email;
            $to_name = \Auth::user()->name;
            \Mail::send("emails.cartAbandon", $data, function($message) use ($to_name, $to_email) {// se envía el email

                $message->to($to_email, $to_name)->subject("¡Tienes productos en tu carro de compras!");
                $message->from("rodriguezwillian95@gmail.com","Deira");

            });
        }
    }

}