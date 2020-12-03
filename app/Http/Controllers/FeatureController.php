<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeatureStoreRequest;
use App\Feature;

class FeatureController extends Controller
{
    
    function index($id){

        return view("admin.feature", ["id" => $id]);

    }

    function fetch($productId){

        $features = Feature::where("product_id", $productId)->get();
        return response()->json(["features" => $features]);

    }

    function store(FeatureStoreRequest $request){

        try{

            $feature = new Feature;
            $feature->feature = $request->feature;
            $feature->description = str_replace("\n", "", $request->description);
            $feature->product_id = $request->product_id;
            $feature->save();

            return response()->json(["success" => true, "msg" => "Carácterística agregada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Ha ocurrido un problema"]);
        }

    }

    function update(FeatureStoreRequest $request){

        try{

            $feature = Feature::where("id", $request->id)->first();
            $feature->feature = $request->feature;
            $feature->description = str_replace("\n", "", $request->description);
            $feature->update();

            return response()->json(["success" => true, "msg" => "Carácterística actualizada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Ha ocurrido un problema"]);
        }

    }

    function delete(Request $request){

        try{

            $feature = Feature::where("id", $request->id)->first()->delete();

            return response()->json(["success" => true, "msg" => "Carácterística eliminada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Ha ocurrido un problema"]);
        }

    }

}
