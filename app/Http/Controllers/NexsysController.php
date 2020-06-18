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
            
            $marks = [ 
                "Wacom",
                "Xerox"
            ];

            foreach($marks as $mark){

                $products = $client->StoreProductByMarks(["Marks" => $mark, "WSClient"=> ["country" => "Chile", "username" => "78198200"]]);
                //dd($products);
                if($mark == "Epson-Escaner" || $mark == "Epson-GranFormato" || $mark == "Epson-Impresion" || $mark == "Epson-POS" || $mark == "Epson-Proyectores"){
                    $mark = "Epson";
                }

                if($mark == "HP-Impresion Consumo" || $mark == "HP-Impresion Corporativo" || $mark == "HP-PCs Empresariales" || $mark == "HP-Portatiles Empresariales" || $mark == "HP-Pos" || $mark == "HP-Workstation"){
                    $mark = "HP";
                }

                if($mark == "Kaspersky Consumo" || $mark == "Kaspersky Corporativo"){
                    $mark = "Kaspersky";
                }

                if($mark == "Lenovo-Corporativo" || $mark == "Lenovo-Servidores" || $mark == "Lenovo-Workstation"){
                    $mark = "Lenovo";
                }

                $brandSlug = str_replace(" ", "-", $mark);
                $brand = Brand::firstOrCreate(
                    ['name' => $mark],
                    ["slug" =>  $brandSlug]
                );

                foreach($products as $product){
        
                    foreach($product as $value){
                        

                            $productSlug = str_replace(" ", "-", $value->short_description);
                            $productSlug = str_replace("/", "-", $productSlug);
                            
                            $excluded_tax = false;
                            if($value->tax_excluded == "true")
                                $excluded_tax = true;

                            $amount = 0;
                            if($value->inventory != "null")
                                $amount = $value->inventory;

                            $testProduct = Product::firstOrCreate(
                                ["sku" => $value->sku],
                                [
                                    "category_id" => 0,
                                    "brand_id" => $brand->id,
                                    "currency" => $value->currency,
                                    "picture" => $value->image,
                                    "is_external" => true,
                                    "parent_nexsys" => $value->parent,
                                    "amount" => $amount,
                                    "description" => $value->long_description,
                                    "min_description" => $value->short_description,
                                    "sub_title" => $value->short_description,
                                    "price" => 0,
                                    "data_source_id" => 1,
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
