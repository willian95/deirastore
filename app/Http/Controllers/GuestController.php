<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GuestStoreRequest;
use App\Guest;

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

}
