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
        $this->sendMessage();
        return view("register");
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
            $user->address = $request->address;
            $user->save();
            
            $data = ["user" => $user, "hash" => $hash];
            $to_name = $user->name;
			$to_email = $user->email;
			\Mail::send("emails.registerEmail", $data, function($message) use ($to_name, $to_email) {

				$message->to($to_email, $to_name)->subject("¡Solo falta un paso tu registro!");
				$message->from("rodriguezwillian95@gmail.com","Deira");

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
