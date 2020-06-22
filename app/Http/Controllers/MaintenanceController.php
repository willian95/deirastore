<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;

class MaintenanceController extends Controller
{
    function index(){

        return view("admin.maintenance");

    }

    function check(){

        if(file_exists(storage_path()."/framework/down")){
            return response()->json(["success" => true]);
        }else{
            return response()->json(["success" => false]);
        }

    }

    function activate(){

        try{
            Artisan::call('down');
            return response()->json(["success" => true, "msg" => "Modo mantenimiento activado"]);
        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }  

    }

    function deactivate(){

        try{
            Artisan::call('up');
            return response()->json(["success" => true, "msg" => "Modo mantenimiento desactivado"]);
        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }  

    }

}
