<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HistoryStoreRequest;
use App\HistoryRangeProfit;
use App\Brand;
use App\Category;
use App\Product;

class RangeProfitController extends Controller
{
    
    function index(){

        return view("admin.priceRange");

    }

    function fetch($page = 1){

        try{

            $take = 20;
            $skip = ($page-1) * $take;
            $historyRangeProfits = HistoryRangeProfit::skip($skip)->take($take)->orderBy('id', "desc")->get();
            $historyRangeProfitCount = HistoryRangeProfit::count();

            return response()->json(["success" => true, "historyRangeProfits" => $historyRangeProfits, "historyRangeProfitCount" => $historyRangeProfitCount]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }

    }

    function apply(HistoryStoreRequest $request){

        try{

            if($request->type == "brands"){

                if(isset($request->brand_id)){
                    $brand = Brand::where("id", $request->brand_id)->first();
                    $log = "Se ha realizado un aumento del ".$request->percentage."% a la marca ".$brand->name;
                    foreach(Product::where("brand_id", $request->brand_id)->get() as $product){
                        
                        $external_price = $product->external_price;
                        $product->price_range_profit = $external_price + ($external_price * ($request->percentage / 100));
                        $product->percentage_range_profit = $request->percentage;
                        $product->update();

                    }

                    $historyRangeProfit = new HistoryRangeProfit;
                    $historyRangeProfit->log = $log;
                    $historyRangeProfit->save();
                }else{

                    return response()->json(["success" => false, "msg" => "Debe seleccionar una marca"]);

                }


            }else if($request->type == "categories"){

                if(isset($request->category_id)){
                    $category = Category::where("id", $request->category_id)->first();
                    $log = "Se ha realizado un aumento del ".$request->percentage."% a la categoría ".$category->esp_name;
                    foreach(Product::where("category_id", $request->category_id)->get() as $product){

                        $external_price = $product->external_price;
                        $product->price_range_profit = $external_price + ($external_price * ($request->percentage / 100));
                        $product->percentage_range_profit = $request->percentage;
                        $product->update();

                    }

                    $historyRangeProfit = new HistoryRangeProfit;
                    $historyRangeProfit->log = $log;
                    $historyRangeProfit->save();
                }else{
                    return response()->json(["success" => false, "msg" => "Debe seleccionar una categoría"]);
                }

            }else if($request->type == "product"){

                if(isset($request->product_id)){
                    $product = Product::where("id", $request->product_id)->first();
                    $log = "Se ha realizado un aumento del ".$request->percentage."% al producto ".$producto->name;
                    foreach(Product::where("id", $request->product_id)->get() as $product){

                        $external_price = $product->external_price;
                        $product->price_range_profit = $external_price + ($external_price * ($request->percentage / 100));
                        $product->percentage_range_profit = $request->percentage;
                        $product->update();

                    }

                    $historyRangeProfit = new HistoryRangeProfit;
                    $historyRangeProfit->log = $log;
                    $historyRangeProfit->save();
                }else{
                    return response()->json(["success" => false, "msg" => "Debe seleccionar un producto"]);
                }

            }

            return response()->json(["success" => true, "msg" => "Rango de precios aplicado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Error en el servidor", "err" => $e->getMessage()]);

        }

    }

}
