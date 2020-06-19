<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HelpCenterStoreRequest;
use App\Http\Requests\HelpCenterUpdateRequest;
use App\HelpCenter;

class HelpCenterController extends Controller
{
    function index(){

        return view("admin.helpCenter");

    }

    function fetch(){

        try{

            $helpCenters = HelpCenter::all();
            return response()->json(["success" => true, "helpCenters" => $helpCenters]);

        }catch(\exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function store(HelpCenterStoreRequest $request){

        try{

            $helpCenter = new HelpCenter;
            $helpCenter->title = $request->title;
            $helpCenter->description = $request->description;
            $helpCenter->save();

            return response()->json(["success" => true, "msg" => "Centro de ayuda creado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function update(HelpCenterUpdateRequest $request){

        try{

            $helpCenter = HelpCenter::where("id", $request->id)->first();
            $helpCenter->title = $request->title;
            $helpCenter->description = $request->description;
            $helpCenter->update();

            return response()->json(["success" => true, "msg" => "Centro de ayuda actualizado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    function delete(Request $request){

        try{

            $helpCenter = HelpCenter::where("id", $request->id)->first();
            $helpCenter->delete();

            return response()->json(["success" => true, "msg" => "Centro de ayuda eliminado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }


}
