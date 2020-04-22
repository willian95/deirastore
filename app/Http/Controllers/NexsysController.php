<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Carbon\Carbon;
use App\Brand;
use App\Product;

class NexsysController extends Controller
{
    
    function index($mark){
        ini_set('max_execution_time', 0);
        //$params = ["encoding" => "UTF-8", "verifypeer" => false, "verifyhost" => false];
        $url = "https://app.nexsysla.com/nexsysServiceSoap/NexsysServiceSoap?wsdl";

        try{
        
            $client = new \SoapClient($url);
            $products = $client->StoreProductByMarks(["Marks" => $mark, "WSClient"=> ["country" => "Chile", "username" => "78198200"]]);
            
            dd($products);

            $brandSlug = str_replace(" ", "-", $mark);
            $brand = Brand::firstOrCreate(
                ['name' => $mark],
                ["slug" =>  $brandSlug]
            );

            foreach($products as $product){
                foreach($product as $value){

                    if(is_string($value->category)){

                        $string = substr($value->category, 3);
                        $convertedString = substr($string, 0, strpos($string, '>') - 1);

                        $slug = str_replace(" ", "-", $convertedString);

                        if(Category::where('slug', $slug)->count() > 0){
                            $slug = $slug."-".Carbon::now()->timestamp;
                        }

                        $category = Category::firstOrCreate(
                            ['name' => $convertedString],
                            ['slug' => $slug]
                        );

                        $productSlug = str_replace(" ", "-", $value->short_description);
                        $productSlug = str_replace("/", "-", $productSlug);
                        
                        $excluded_tax = false;
                        if($value->tax_excluded == "true")
                            $excluded_tax = true;

                        $amount = 0;
                        if($value->inventory != "null")
                            $amount = $value->inventory;

                        $testProduct = Product::updateOrCreate(
                            ["sku" => $value->sku],
                            [
                                "category_id" => $category->id,
                                "brand_id" => $brand->id,
                                "currency" => $value->currency,
                                "picture" => $value->image,
                                "is_external" => true,
                                "amount" => $amount,
                                "description" => $value->long_description,
                                "min_description" => $value->short_description,
                                "sub_title" => $value->short_description,
                                "price" => 0,
                                "tax_excluded" => $excluded_tax,
                                "name" => $value->short_description,
                                "slug" => $productSlug,
                                "external_price" => floatval($value->price)
                            ]
                        );

                    }

                }
            }

            //return true;

        }catch(\SoapFault $fault){
            dd($fault);
        }

    }

}
