<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeatureStoreRequest;
use App\Product;

class FeatureController extends Controller
{
    
    function index($id){

        $product = Product::where("id", $id)->withTrashed()->first();
        return view("admin.feature", ["id" => $id, "product" => $product]);

    }

    function update(FeatureStoreRequest $request){

        try{
            //
            $product = Product::where("id", $request->id)->first();
            $product->feature = $request->feature;
            $product->update();

            return response()->json(["success" => true, "msg" => "Carácterística actualizada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Ha ocurrido un problema", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }


}
