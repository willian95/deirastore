<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Product;
use App\Category;
use Carbon\Carbon;

class ProductController extends Controller
{
    
    function index(){
        return view('admin.products');
    }

    function fetch(Request $request){

        try{

            $skip = ($request->page-1) * 10;

            $categories = Category::all();
            $products = Product::skip($skip)->take(10)->get();
            $productsCount = Product::count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount, "categories" => $categories]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function store(StoreProduct $request){

        try{

            $imageData = $request->get('picture');
            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($request->get('picture'))->save(public_path('images/products/').$fileName);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => $e->getMessage()]);

        }


        try{
            
            $product = new Product;
            $product->name = $request->name;
            $product->sub_title = $request->subTitle;
            $product->price = $request->price;
            $product->sub_price = $request->subPrice;
            $product->picture = $fileName;
            $product->description = $request->description;
            $product->category_id = $request->categoryId;
            $product->save();

            return response()->json(["success" => true, "msg" => "Producto registrado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function update(UpdateProduct $request){

        if($request->has('image')){
            try{

                $imageData = $request->get('picture');
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('picture'))->save(public_path('images/products/').$fileName);
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => $e->getMessage()]);
    
            }
        }

        try{
            
            $product = Product::find($request->productId);
            $product->name = $request->name;
            $product->sub_title = $request->subTitle;
            $product->price = $request->price;
            $product->sub_price = $request->subPrice;
            if($request->has('image')){
                $product->picture = $fileName;
            }
            $product->description = $request->description;
            $product->category_id = $request->categoryId;
            $product->update();

            return response()->json(["success" => true, "msg" => "Producto actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "error" => $e->getMessage()]);

        }

    }

    function search(Request $request){

        $products = Product::where('name', 'like', '%'.$request->search.'%')->get();
        return response()->json(["products" => $products]);

    }

    function delete(Request $request){

        try{

            $product = Product::find($request->id);
            $product->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function show($id){

        try{

            $product = Product::with('category')->where('id', $id)->first();            
            return response()->json(["success" => true, "product" => $product]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

}
