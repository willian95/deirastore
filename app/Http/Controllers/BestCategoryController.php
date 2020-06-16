<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BestCategoriesStoreRequest;
use App\BestCategory;

class BestCategoryController extends Controller
{
    function index(){

        return view("admin.bestCategories");

    }

    function fetch(){

        try{

            $BestCategories = BestCategory::with("category")->get();
            return response()->json(["success" => true, "bestCategories" => $BestCategories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function store(BestCategoriesStoreRequest $request){

        try{

            if(BestCategory::count() < 12){
                $bestCategory = new BestCategory;
                $bestCategory->category_id = $request->category;
                $bestCategory->save();

                return response()->json(["success" => true, "msg" => "Categoría principal creada"]);

            }else{
                return response()->json(["success" => false, "msg" => "Ya ha alcanzado el máximo de categorias principales"]);
            }

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

    public function delete(Request $request){

        try{

            BestCategory::where("id", $request->id)->delete();
            return response()->json(["success" => true, "msg" => "Categoría principal eliminada"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }
}
