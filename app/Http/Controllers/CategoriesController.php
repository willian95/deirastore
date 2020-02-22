<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategories;
use App\Http\Requests\UpdateCategories;
use Illuminate\Http\Request;
use App\Category;

class CategoriesController extends Controller
{
    
    function index(){
        return view('admin.categories');
    }

    function store(StoreCategories $request){

        try{
            
            $category = new Category;
            $category->name = $request->name;
            $category->save();

            return response()->json(["success" => true, "msg" => "Categoría registrada"]);

        }catch(\Exception $e){

            return resonse()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function update(UpdateCategories $request){

        try{
            
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->update();

            return response()->json(["success" => true, "msg" => "Categoría actualizada"]);

        }catch(\Exception $e){

            return resonse()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function fetch(Request $request){

        try{

            $skip = ($request->page-1) * 10;

            $categories = Category::skip($skip)->take(10)->get();
            $categoriesCount = Category::count();

            return response()->json(["success" => true, "categories" => $categories, "categoriesCount" => $categoriesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function search(Request $request){

        $categories = Category::where('name', 'like', '%'.$request->search.'%')->get();
        return response()->json(["categories" => $categories]);

    }

    function delete(Request $request){

        try{

            $category = Category::find($request->id);
            $category->delete();

            return response()->json(["success" => true, "msg" => "Categoría eliminada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }



    }


}
