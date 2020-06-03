<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    function index(){

        if(Auth::check() && Auth::user()->id != null){
            return redirect()->to('/');
        }

        return view('login');

    }

    function logIn(Request $request){

        $credentials = $request->only('email', 'password');
        
        if(User::where('email', $request->email)->first()){
            if(User::where('email', $request->email)->first()->email_verified_at == null)
                return response()->json(["success" => false, "msg" => "Aún no has verificado tu correo"]);
        }

        if (Auth::attempt($credentials, true)){
            
            $user = User::where('email', $request->email)->first();
            return response()->json(["success" => true, "msg" => "Has iniciado sesión", "user" => $user]);
        
        }

        return response()->json(["success" => false, "msg" => "Usuario o contraseña incorrectos"]);

    }

    function logout(){

        Auth::logout();
        return redirect()->to('/');
    }

}
