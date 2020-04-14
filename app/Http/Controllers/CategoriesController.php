<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategories;
use App\Http\Requests\UpdateCategories;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Category;

class CategoriesController extends Controller
{
    
    function index(){
        return view('admin.categories');
    }

    function store(StoreCategories $request){

        try{

            $imageData = $request->get('image');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path('images/categories/').$fileName);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen"]);

        }

        try{
            
            $category = new Category;
            $category->name = $request->name;
            $category->image = $fileName;
            $category->save();

            return response()->json(["success" => true, "msg" => "Categoría registrada"]);

        }catch(\Exception $e){

            return resonse()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function update(UpdateCategories $request){

        if($request->get('image') != null){
            try{

                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/categories/').$fileName);

            }catch(\Exception $e){

                return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen"]);

            }
        }
        try{
            
            $category = Category::find($request->id);
            $category->name = $request->name;
            if($request->get('image') != null){
                $category->image = $fileName;
            }
            $category->update();

            return response()->json(["success" => true, "msg" => "Categoría actualizada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

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
