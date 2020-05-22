<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategories;
use App\Http\Requests\UpdateCategories;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Category;
use App\Product;
use App\Traits\CartAbandonTrait;

class CategoriesController extends Controller
{
    
    use CartAbandonTrait;

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

            $slug = str_replace(" ", "-", $request->name);

            if(Product::where('slug', $slug)->count() > 0){
                $slug = $slug."-".Carbon::now()->timestamp;
            }
            
            $category = new Category;
            $category->name = $request->name;
            $category->image = $fileName;
            $category->slug = $slug;
            $category->parent_id = $request->parentId;
            $category->save();

            return response()->json(["success" => true, "msg" => "Categoría registrada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(UpdateCategories $request){

        if($request->get('image') != null){
            try{

                $imageData = $request->get('image');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/categories/').$fileName);

            }catch(\Exception $e){

                return response()->json(["success" => false, "msg" => "Hubo un error al cargar la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

            }
        }
        try{

            $slug = str_replace(" ", "-", $request->name);

            if(Product::where('slug', $slug)->where('id', '<>', $request->productId)->count() > 0){
                $slug = $slug."-".Carbon::now()->timestamp;
            }
            
            $category = Category::find($request->id);
            $category->name = $request->name;
            if($request->get('image') != null){
                $category->image = $fileName;
            }
            $category->parent_id = $request->parentId;
            $category->slug = $slug;
            $category->update();

            return response()->json(["success" => true, "msg" => "Categoría actualizada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetch(Request $request){

        try{

            $skip = ($request->page-1) * 10;

            $categories = Category::with("parent")->skip($skip)->take(10)->get();
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

    function slug($slug){

        $this->sendMessage();
        $category = Category::where('slug', $slug)->first();
        return view('categorySlug', ["slug" => $slug, "category" => $category]);

    }

    function products(Request $request){

        try{

            $skip = ($request->page-1) * 20;
            $category = Category::where('slug', $request->slug)->first();

            $products = Product::where('category_id', $category->id)->with('category')->skip($skip)->take(20)->get();
            $productsCount = Product::where('category_id', $category->id)->with('category')->count();
            $subCategories = Category::where('parent_id', $category->id)->get();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount, "subCategories" => $subCategories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function categoriesAll(){

        try{

            $categories = Category::all();
            return response()->json(["success" => true, "categories" => $categories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function megaMenu($skip = 0){

        try{
            
            $take = 18;
            $categories = Category::with('child')->skip($skip)->take($take)->orderBy('name')->get();
            $categoriesCount = Category::with('child')->count();

            $categoriesArray= [];
            $index = 0;
            
            foreach($categories as $category){

                if($index < $take){
                    if(count($category->child) || Product::where('category_id', $category->id)->count() > 0){

                        $categoriesArray[] = [
                            "id" => $category->id,
                            "name" => $category->name,
                            "slug" => $category->slug,
                            "child" => $category->child
                        ];
    
                    }
                    $index++;
                }
                $skip++;
            }

            //return response()->json(["success" => true, "categories" => $categoriesArray, "categoriesCount" => $categoriesCount]);
            return response()->json(["success" => true, "categories" => $categoriesArray, "categoriesCount" => $categoriesCount, "skip" => $skip]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }


}
