<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RutController extends Controller
{
    
    function validateRut($rut){

        try{

            $indicator = substr($rut, strlen($rut)-1, strlen($rut));
            $formatedString = number_format(substr($rut, 0, strlen($rut)-1), 0, ",", ".");
            $queryRut = $formatedString."-".$indicator;

            
            $client = new \GuzzleHttp\Client();
            $request = $client->request("GET", 'https://siichile.herokuapp.com/consulta?rut='.$queryRut);
            $response = json_decode($request->getBody());
        
            if($response->razon_social){
                return response()->json(["success" => true, "data" => true, "msg" => "Rut válido"]);
            }else{
                return response()->json(["success" => false, "data" => false, "msg" => "Rut no válido"]);
            }



        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }

    }

}   
