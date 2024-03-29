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
            $products = Product::skip($skip)->take(10)->withTrashed()->get();
            $productsCount = Product::withTrashed()->count();

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
            $product->external_price = $request->price;
            $product->sub_price = $request->price;
            $product->picture = url('/').'/images/products/'.$fileName;
            $product->slug = $slug;
            $product->description = $request->description;
            $product->category_id = $request->categoryId;
            $product->brand_id = $request->brandId;
            $product->sku = $request->vpn;
            $product->amount = $request->stock;
            //$product->vpn = $request->vpn;
            $product->min_description = $request->min_description;
            $product->product_type = $request->product_type;
            $product->product_material = $request->product_material;
            $product->dimenssions = $request->dimenssions;
            $product->weight = $request->weight;
            $product->features = $request->features;
            $product->location = $request->location;
            $product->warranty = $request->warranty;
            $product->color = $request->color;
            if(isset($request->dataSourceId)){
                $product->data_source_id = $request->dataSourceId;
            }else{
                $product->data_source_id = 0;
            }
            
            $product->is_external = false;
            $product->sale_price = $request->salePrice;
            
            $product->save();

            return response()->json(["success" => true, "msg" => "Producto registrado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function update(UpdateProduct $request){

        if($request->get('picture') != null){
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
            $product->amount = $request->stock;
            $product->external_price = $request->price;
            $product->sub_title = $request->subTitle;
            if($request->price > 0 && $product->price_range_profit != $request->price){
                $product->percentage_range_profit = 1;
            }else{
                $product->percentage_range_profit = null;
            }

            if($request->price == "null"){
                $product->price_range_profit = 0;
            }else{
                $product->price_range_profit = $request->price;
            }

            //$product->percentage_range_profit = $request->percentage_range_profit;
            $product->sub_price = $request->subPrice;
            if($request->get('picture') != null){
                $product->picture = url('/').'/images/products/'.$fileName;
            }
            $product->description = $request->description;
            //$product->slug = $slug;
            $product->category_id = $request->categoryId;
            $product->brand_id = $request->brandId;
            $product->sku = $request->vpn;
         
            if($request->min_description == "null"){
                $product->min_description = null;
            }else{
                $product->min_description = $request->min_description;
            }

            if($request->product_type == "null"){
                $product->product_type = null;
            }else{
                $product->product_type = $request->product_type;
            }

            if($request->product_material == "null"){
                $product->product_material = null;
            }else{
                $product->product_material = $request->product_material;
            }

            if($request->dimenssions == "null"){
                $product->dimenssions = null;
            }else{
                $product->dimenssions = $request->dimenssions;
            }

            if($request->dimenssions == "null"){
                $product->dimenssions = null;
            }else{
                $product->dimenssions = $request->dimenssions;
            }
            
            if($request->weight == "null"){
                $product->weight = null;
            }else{
                $product->weight = $request->weight;
            }

            if($request->features == "null"){
                $product->features = null;
            }else{
                $product->features = $request->features;
            }

            if($request->location == "null"){
                $product->location = null;
            }else{
                $product->location = $request->location;
            }

            if($request->warranty == "null"){
                $product->warranty = null;
            }else{
                $product->warranty = $request->warranty;
            }

            if($request->color == "null"){
                $product->color = null;
            }else{
                $product->color = $request->color;
            }

            if($request->dataSourceId == "null"){
                $product->data_source_id = null;
            }else{
                $product->data_source_id = $request->dataSourceId;
            }

            $product->sale_price = $request->salePrice;

            $product->update();

            return response()->json(["success" => true, "msg" => "Producto actualizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "error" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function search(Request $request){

        $skip = ($request->page-1) * 20;

        //$products = Product::where('name', 'like', '%'.$request->search.'%')->get();
        $products = Product::with("category", "brand")->withTrashed()
        ->where(function ($query) use($request) {
           
            //$query->orWhere('description', "like", "%".$words[$i]."%");
            $query->orWhere('name', "like", "%".$request->search."%");
            $query->orWhere('sku', "like", "%".$request->search."%");
                    
        })
        ->skip($skip)->take(20)->orderBy("name")->get();

        $productsCount = Product::with("category", "brand")->withTrashed()
        ->where(function ($query) use($request) {
           
            //$query->orWhere('description', "like", "%".$words[$i]."%");
            $query->orWhere('name', "like", "%".$request->search."%");
            $query->orWhere('sku', "like", "%".$request->search."%");
                    
        })
        ->count();

        return response()->json(["products" => $products, "productsCount" => $productsCount]);

    }

    function delete(Request $request){

        try{

            $product = Product::where("id", $request->id)->first();
            $product->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function restore(Request $request){

        try{

            $product = Product::where("id", $request->id)->onlyTrashed()->first();
            $product->restore();

            return response()->json(["success" => true, "msg" => "Producto restaurado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor"]);

        }

    }

    function hardDelete(Request $request){

        try{

            $product = Product::where("id", $request->id)->forceDelete();

            return response()->json(["success" =>true, "msg" => "Producto eliminado completamente"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);
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
