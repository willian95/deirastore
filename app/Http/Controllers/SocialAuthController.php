<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;

class SocialAuthController extends Controller
{
    
    public function redirectToGoogle(Request $request)
    {
        session(["path" => $request->path]);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            
            $googleUser = Socialite::driver('google')->user();
     
            $existUser = User::where('email',$googleUser->email)->first();
            
            if($existUser) {
                Auth::loginUsingId($existUser->id);
            }
            else {
                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->password = md5(rand(1,10000));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            
            if(session("path") == null)
                return redirect()->to('/');
            else
                return redirect()->to(session("path"));
            
            //return redirect()->intended("/");

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToFacebook(Request $request)
    {
        session(["path" => $request->path]);
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
    
            // Obtenemos los datos del usuario
            $social_user = Socialite::driver("facebook")->user(); 
            // Comprobamos si el usuario ya existe
            if ($user = User::where('email', $social_user->email)->first()) { 
                //return $this->authAndRedirect($user); // Login y redirección
                Auth::loginUsingId($user->id);
            } else {  
                // En caso de que no exista creamos un nuevo usuario con sus datos.
                $user = new User;
                $user->name = $social_user->name;
                $user->email = $social_user->email;
                $user->facebook_id = $social_user->id;
                $user->save();
                Auth::loginUsingId($user->id);

            }

            if(session("path") == null)
                return redirect()->to('/');
            else
                return redirect()->to(session("path"));
    
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

}
