<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Product;
use App\Category;
use Carbon\Carbon;
use App\Brand;
use App\Traits\CartAbandonTrait;

class ProductController extends Controller
{
    use CartAbandonTrait;
    function index(){
        return view('admin.products');
    }

    function fetch(Request $request){

        try{

            $skip = ($request->page-1) * 10;

            $categories = Category::all();
            $brands = Brand::all();
            $products = Product::skip($skip)->take(10)->get();
            $productsCount = Product::count();

            return response()->json(["success" => true, "products" => $products, "productsCount" => $productsCount, "categories" => $categories, "brands" => $brands]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

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
            
            $slug = str_replace(" ", "-", $request->name);

            if(Product::where('slug', $slug)->count() > 0){
                $slug = $slug."-".Carbon::now()->timestamp;
            }

            $product = new Product;
            $product->name = $request->name;
            $product->sub_title = $request->subTitle;
            $product->price = $request->price;
            $product->sub_price = $request->subPrice;
            $product->picture = $fileName;
            $product->slug = $slug;
            $product->description = $request->description;
            $product->category_id = $request->categoryId;
            $product->brand_id = $request->brandId;
            $product->sku = $request->sku;
            $product->vpn = $request->vpn;
            $product->min_description = $request->min_description;
            $product->product_type = $request->product_type;
            $product->product_material = $request->product_material;
            $product->dimenssions = $request->dimenssions;
            $product->weight = $request->weight;
            $product->features = $request->features;
            $product->location = $request->location;
            $product->warranty = $request->warranty;
            $product->color = $request->color;
            $product->is_external = false;
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
            
            $slug = str_replace(" ", "-", $request->name);

            if(Product::where('slug', $slug)->where('id', '<>', $request->productId)->count() > 0){
                $slug = $slug."-".Carbon::now()->timestamp;
            }

            $product = Product::find($request->productId);
            $product->name = $request->name;
            $product->sub_title = $request->subTitle;
            $product->price = $request->price;
            $product->sub_price = $request->subPrice;
            if($request->has('image')){
                $product->picture = $fileName;
            }
            $product->description = $request->description;
            $product->slug = $slug;
            $product->category_id = $request->categoryId;
            $product->brand_id = $request->brandId;
            $product->sku = $request->sku;
            $product->vpn = $request->vpn;
            $product->min_description = $request->min_description;
            $product->product_type = $request->product_type;
            $product->product_material = $request->product_material;
            $product->dimenssions = $request->dimenssions;
            $product->weight = $request->weight;
            $product->features = $request->features;
            $product->location = $request->location;
            $product->warranty = $request->warranty;
            $product->color = $request->color;
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

            $product = Product::with('category', 'brand')->where('id', $id)->first();         
            return response()->json(["success" => true, "product" => $product]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function highlighted(){
        $this->sendMessage();
        return view('highlightedProducts');
    }

}
