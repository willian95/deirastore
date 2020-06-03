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

            //iniciamos curl
            $ch = curl_init();

            //Le pasamos la url a curl, y formateamos el día, mes, año y el nombre del día, que siempre serán jueves y sábados
            curl_setopt($ch,CURLOPT_URL,'https://www.nombrerutyfirma.com/rut808');
                //Le pasamos a curl un useragent
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
                //Le pasamos a curl el header del idioma
            curl_setopt($ch,CURLOPT_HTTPHEADER,array("Accept-Language: es-es,en"));
                //Número máximo de segundos para ejecutar funciones curl
            curl_setopt($ch,CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "term=".$queryRut);
                //Le pasamos True, 1, para seguir cualquier encabezado location
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
                //Le pasamos true, 1, para que nos devuelva el resultado en una string
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);    
        
            //Guardar pagina
            $result = curl_exec($ch); 
            $error = curl_error($ch); 
            curl_close($ch); //Cerramos la conexion CURL.
            

            if(strpos($result."", "<td>")){
                return response()->json(["success" => true, "data" => true, "msg" => "Rut válido"]);
            }else{
                return response()->json(["success" => false, "data" => false, "msg" => "Rut no válido"]);
            }



        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

}   
