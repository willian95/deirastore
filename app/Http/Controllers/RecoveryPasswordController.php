<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecoveryRequest;
use App\Http\Requests\PasswordRestoreRequest;
use Illuminate\Support\Str;
use App\User;

class RecoveryPasswordController extends Controller
{
    
    function index(){

        return view('passwordRecoveryIndex');

    }

    function send(RecoveryRequest $request){

        try{

            $user = User::where("email", $request->email)->first();

            if($user){

                $random = Str::random(40)."-".uniqid();
                
                $user->recovery_hash = $random;
                $user->update();

                $to_name = $user->name;
                $to_email = $user->email;
                return response()->json(env("MAIL_FROM_ADDRESS"));
                $data = ["user" => $user];
                \Mail::send("emails.recoveryMail", $data, function($message) use ($to_name, $to_email) {

                    $message->to($to_email, $to_name)->subject("¡Recupera tu clave!");
                    $message->from(env("MAIL_FROM_ADDRESS"),"Deira");

                });

                return response()->json(["success" => true, "msg" => "Hemos enviado un correo a tu email"]);

            }else{
                return response()->json(["success" => false, "msg" => "Email no encontrado"]);
            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function restore($recovery_hash){

        try{

            $user = User::where('recovery_hash', $recovery_hash)->first();
            
            if($user){
                return view('passwordRestore', ["recovery_hash" => $recovery_hash]);
            }else{
                abort(403);
            }

        }catch(\Exception $e){

            abort(403);

        }

    }

    function update(PasswordRestoreRequest $request){

        try{

            $user = User::where('recovery_hash', $request->recovery_hash)->first();

            if($user){
            
                $user->recovery_hash = "";
                $user->password = bcrypt($request->password);
                $user->update();
                
                return response()->json(["success" => true, "msg" => "Clave recuperada"]);

            }else{

                return response()->json(["success" => false, "msg" => "Usuario no encontrado"]);

            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
