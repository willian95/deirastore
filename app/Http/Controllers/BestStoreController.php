<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BestStoresStoreRequest;
use App\BestStore;

class BestStoreController extends Controller
{
    
    function index(){

        return view("admin.bestStores");

    }

    function fetch(){

        try{

            $bestStores = BestStore::with("brand")->get();
            return response()->json(["success" => true, "bestStores" => $bestStores]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function store(BestStoresStoreRequest $request){

        try{

            if(BestStore::count() < 12){
                $bestStore = new BestStore;
                $bestStore->brand_id = $request->brand;
                $bestStore->save();

                return response()->json(["success" => true, "msg" => "Mejores Tiendas creada"]);

            }else{
                return response()->json(["success" => false, "msg" => "Ya ha alcanzado el máximo de mejores tiendas"]);
            }

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    public function delete(Request $request){

        try{

            BestStore::where("id", $request->id)->delete();
            return response()->json(["success" => true, "msg" => "Mejores Tiendas eliminada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
