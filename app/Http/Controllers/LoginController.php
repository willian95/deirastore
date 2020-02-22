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

        if (Auth::attempt($credentials)) {
            
            $user = User::where('email', $request->email)->first();
            return response()->json(["success" => true, "msg" => "Has iniciado sesión", "user" => $user]);
        
        }

        return response()->json(["success" => false, "msg" => "Usuario no encontrado"]);

    }

    function logout(){
        Auth::logout();
        return redirect()->to('/');
    }

}
