<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use App\User;

class RegisterController extends Controller
{
    function index(){
        return view("register");
    }
    
    function register(RegisterUser $request){

        try{
    
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->genre = $request->genre;
            $user->birth_date = $request->birthDate;
            $user->rut = $request->rut;
            $user->phone_number = $request->phoneNumber;
            $user->save();

            return response()->json(["success" => true, "msg" => "Has sido registrado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "error" => $e->getMessage()]);

        }

    }

}
