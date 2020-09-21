<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use Illuminate\Support\Str;
use App\User;
use Carbon\Carbon;
use App\Traits\CartAbandonTrait;

class RegisterController extends Controller
{

    use CartAbandonTrait; 

    function index(){
        //$this->sendMessage();
        return view("register");
    }

    function resendEmail($email){

        try{
            //return response()->json(env("APP_ENV"));
            $user = User::where("email", $email)->first();

            if($user){

                $hash = Str::random(40)."-".uniqid();
                $user->register_hash = $hash;
                $user->update();
                
                $data = ["user" => $user, "hash" => $user->register_hash];
                $to_name = $user->name;
                $to_email = $user->email;
                //return response()->json(env("MAIL_FROM_ADDRESS"));
                //$data = ["user" => $user];
                \Mail::send("emails.registerEmail", $data, function($message) use ($to_name, $to_email) {

                    $message->to($to_email, $to_name)->subject("¡Solo falta un paso tu registro!");
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
    
    function register(RegisterUser $request){

        try{
            
            $hash = Str::random(40)."-".uniqid();

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->genre = $request->genre;
            $user->birth_date = $request->birthDate;
            $user->rut = $request->rut;
            $user->lastname = $request->lastname;
            $user->phone_number = $request->phoneNumber;
            $user->register_hash = $hash;
            $user->location_id = $request->location;
            $user->street = $request->street;
            $user->comune_id = $request->comune_id;
            $user->house = $request->house;
            $user->number = $request->number;

            if($request->showBusiness == true){
                $user->business_name = $request->businessName;
                $user->business_rut = $request->businessRut;
                $user->business_address = $request->businessAddress;
                $user->business_phone = $request->businessPhone;
                $user->business_mail = $request->businessMail;
            }

            $user->save();
            
            $data = ["user" => $user, "hash" => $hash];
            $to_name = $user->name;
			$to_email = $user->email;
			\Mail::send("emails.registerEmail", $data, function($message) use ($to_name, $to_email) {

				$message->to($to_email, $to_name)->subject("¡Solo falta un paso tu registro!");
				$message->from(env("MAIL_FROM_ADDRESS"),"Deira");

			});


            return response()->json(["success" => true, "msg" => "Gracias por registrarte"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "error" => $e->getMessage()]);

        }

    }

    function confirmEmail($hash){

        try{

            $user = User::where('register_hash', $hash)->first();
            $user->register_hash = null;
            $user->email_verified_at = Carbon::now();
            $user->update();

            \Auth::loginUsingId($user->id);

            return redirect()->to('/');

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "error" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
