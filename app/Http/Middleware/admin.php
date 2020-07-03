<?php

namespace App\Http\Middleware;

use Closure;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(\Auth::guest()){
            return redirect()->to("/");
        }else{

            if(\Auth::user()->rol_id == 2){
                return redirect()->to("/");
            }
            else if(\Auth::user()->rol_id == 1){
                return redirect()->to("/");
            }
        }

        return $next($request);
    }
}
