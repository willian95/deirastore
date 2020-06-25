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
use App\Imports\CategoriesWeightImport;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesController extends Controller
{
    
    use CartAbandonTrait;

    function index(){
        return view('admin.categories');
    }

    function store(StoreCategories $request){

        try{

            $imageData = $request->get('image');

            if(strpos($imageData, "svg+xml") > 0){

                $data = explode( ',', $imageData);
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                $ifp = fopen($fileName, 'wb' );
                fwrite($ifp, base64_decode( $data[1] ) );
                rename($fileName, 'images/categories/'.$fileName);

            }else{

                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/categories/').$fileName);
            }

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
                
                if(strpos($imageData, "svg+xml") > 0){

                    $data = explode( ',', $imageData);
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                    $ifp = fopen($fileName, 'wb' );
                    fwrite($ifp, base64_decode( $data[1] ) );
                    rename($fileName, 'images/categories/'.$fileName);

                }else{
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                    Image::make($request->get('image'))->save(public_path('images/categories/').$fileName);
                }

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

            $categories = Category::with("parent")->skip($skip)->take(10)->orderBy("esp_name", "asc")->get();
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

        //$this->sendMessage();
        $category = Category::where('slug', $slug)->first();
        return view('categorySlug', ["slug" => $slug, "category" => $category]);

    }

    function products(Request $request){

        try{

            $skip = ($request->page-1) * 20;
            $category = Category::where('slug', $request->slug)->first();

            $orderBy = "";
            if($request->filterOrder == 1){
                $orderBy = "name asc";
            }
            else if($request->filterOrder == 2){
                $orderBy = "name desc";
            }
            else if($request->filterOrder == 3){
                $orderBy = "case when percentage_range_profit >= 0 then price_range_profit else external_price end asc";
            }
            else if($request->filterOrder == 4){
                $orderBy = "case when percentage_range_profit >= 0 then price_range_profit else external_price end desc";
            }
            else if($request->filterOrder == 5){
                $orderBy = "amount asc";
            }
            else if($request->filterOrder == 6){
                $orderBy = "amount desc";
            }


            $products = Product::where('category_id', $category->id)->with('category')->with("brand")->skip($skip)->take(20)
                        ->orderByRaw($orderBy)
                        ->get();
            $productsCount = Product::where('category_id', $category->id)->with('category')->with("brand")->count();
            $subCategories = Category::where('parent_id', $category->id)->get();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount, "subCategories" => $subCategories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function categoriesAll(){

        try{

            $categories = Category::orderBy("esp_name", "asc")->get();
            return response()->json(["success" => true, "categories" => $categories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function megaMenu($page = 1){

        try{

            
            $take = 25;
            $skip = ($page-1) * $take;
            $categories = Category::with('child')->whereNull("parent_id")->skip($skip)->take(25)->orderBy('esp_name')->get();
            $categoriesCount = Category::with('child')->whereNull("parent_id")->count();
            //$categories = Category::has('products', '>', 0)->with('child')->skip($skip)->take(25)->orderBy('name')->get();
            //$categoriesCount = Category::has('products', '>', 0)->with('child')->count();

            return response()->json(["success" => true, "categories" => $categories, "categoriesCount" => $categoriesCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    public function import() 
    {
        ini_set('max_execution_time', 0);
        
        try{

            Excel::import(new CategoriesWeightImport, 'categories_weight.xlsx', "ingram");
            //dd("done");

        }catch(\Exception $e){
            dd($e->getMessage(), $e->getLine());
        }
        //return redirect('/')->with('success', 'All good!');
    }


}
