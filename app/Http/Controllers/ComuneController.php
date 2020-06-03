<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comune;

class ComuneController extends Controller
{
    
    function getComunesByRegion($region_id){

        try{

            $comune = Comune::where("region_id", $region_id)->get();

            return response()->json(["success" => true, "comunes" => $comune]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

}
