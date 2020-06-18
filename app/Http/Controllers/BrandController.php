<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use Intervention\Image\Facades\Image;
use App\Brand;
use Carbon\Carbon;
use App\Product;
use App\Traits\CartAbandonTrait;

class BrandController extends Controller
{
    
    use CartAbandonTrait;

    function index(){
        return view('admin.brands');
    }

    function store(BrandStoreRequest $request){

        try{

            $imageData = $request->get('image');

            if(strpos($imageData, "svg+xml") > 0){

                $data = explode( ',', $imageData);
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                $ifp = fopen($fileName, 'wb' );
                fwrite($ifp, base64_decode( $data[1] ) );
                rename($fileName, 'images/brands/'.$fileName);

            }else{

                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/brands/').$fileName);

            }

            

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

        try{

            $slug = str_replace(" ", "-", $request->name);

            if(Product::where('slug', $slug)->count() > 0){
                $slug = $slug."-".Carbon::now()->timestamp;
            }

            $brand = new Brand;
            $brand->name = $request->name;
            $brand->image = $fileName;
            $brand->slug = $slug;
            $brand->save();

            return response()->json(["success" => true, "msg" => "Tienda creada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(BrandUpdateRequest $request){

        

        if($request->get('image') != null){
            
            try{

                $imageData = $request->get('image');

                if(strpos($imageData, "svg+xml") > 0){

                    $data = explode( ',', $imageData);
                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'."svg";
                    $ifp = fopen($fileName, 'wb' );
                    fwrite($ifp, base64_decode( $data[1] ) );
                    rename($fileName, 'images/brands/'.$fileName);
    
                }else{

                    $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                    Image::make($request->get('image'))->save(public_path('images/brands/').$fileName);
                }
    
            }catch(\Exception $e){
    
                return response()->json(["success" => false, "msg" => "Hubo un problema con la imagen", "err" => $e->getMessage(), "ln" => $e->getLine()]);
    
            }
        }

        try{

            $slug = str_replace(" ", "-", $request->name);

            if(Product::where('slug', $slug)->where('id', '<>', $request->productId)->count() > 0){
                $slug = $slug."-".Carbon::now()->timestamp;
            }

            $brand = Brand::find($request->brandId);
            $brand->name = $request->name;
            if($request->get('image') != null){
                $brand->image = $fileName;
            }
            $brand->slug = $slug;
            $brand->update();

            return response()->json(["success" => true, "msg" => "Tienda actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }
    function fetch(Request $request){

        try{

            $skip = ($request->page-1) * 10;

            $brands = Brand::skip($skip)->take(10)->orderBy("name", "asc")->get();
            $brandsCount = Brand::count();

            return response()->json(["success" => true, "brands" => $brands, "brandsCount" => $brandsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function delete(Request $request){

        try{

            $brand = Brand::find($request->id);
            $brand->delete();

            return response()->json(["success" => true, "msg" => "Tienda eliminada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor",  "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function search(Request $request){

        $brands = Brand::where('name', 'like', '%'.$request->search.'%')->get();
        return response()->json(["brands" => $brands]);

    }

    function brands(){
        //$this->sendMessage();
        return view('allBrands');

    }

    function slug($slug){
        //$this->sendMessage();
        $brand = Brand::where('slug', $slug)->first();
        return view('brandSlug', ["slug" => $slug, "brand" => $brand]);

    }

    function products(Request $request){

        try{

            $skip = ($request->page-1) * 20;
            $brand = Brand::where('slug', $request->slug)->first();

            $products = Product::where('brand_id', $brand->id)->with('category')->with("brand")->skip($skip)->take(20)->get();
            $productsCount = Product::where('brand_id', $brand->id)->with('category')->with("brand")->count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetchAll(){

        try{

            $brands = Brand::orderBy("name", "asc")->get();
            return response()->json(["success" => true, "brands" => $brands]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

}
