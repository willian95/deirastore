<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdate;
use App\User;
use App\Traits\CartAbandonTrait;

class ProfileController extends Controller
{
    
    use CartAbandonTrait;

    function index(){
        $this->sendMessage();
        return view('profile');
    }

    function update(ProfileUpdate $request){

        try{

            if(strlen($request->password) > 0){

                if($request->password != $request->passwordRepeat){
                    return response()->json(["success" => false, "msg" => "Contraseñas no coinciden"]);
                }

            }

            if(User::where('rut', $request->rut)->where('id', '<>', \Auth::user()->id)->count() > 0){

                return response()->json(["success" => false, "msg" => "Este rut pertenece a otra persona"]);

            }

            $user = User::find(\Auth::user()->id);
            $user->name = $request->name;
            $user->genre = $request->genre;
            $user->birth_date = $request->birthDate;
            $user->phone_number = $request->phoneNumber;

            if(strlen($request->password) > 0){
                
                $user->password = bcrypt($request->password);

            }

            $user->update();

            return response()->json(["success" => true, "msg" => "Perfil actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

}
