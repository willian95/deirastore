<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class AdminSearchController extends Controller
{
    
    function index(){

        return view("admin.searchOptions");

    }

    function update(Request $request){

        try{

            $category = Category::where("id", $request->categoryId)->first();
            $category2 = Category::where("search_position", $request->position)->first();
            $category2->search_position = $category->search_position;
            $category->search_position = $request->position;
            $category->update();
            $category2->update();

            return response()->json(["success" => true, "msg" => "Posición actualizada"]);

            //$category->update();

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);
        }

    }

}
