<?php

namespace App\Imports;

use App\Product;
use App\Brand;
use App\Category;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

//class IngramImport implements ToModel, ToCollection
class IngramImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        try{

            $index = 0;
            $counter = 0;
            foreach ($rows as $row) 
            {
                
                if($index > 0 && $row[0] != ""){
                    
                    //dd(substr($row[0], 11, strlen($row[0])));
                    $brandSlug = str_replace("-", "", $row[3]);
                    $brandSlug = str_replace(" ", "-", $brandSlug);
                    $brand = Brand::firstOrCreate(
                        ['name' => $row[3]],
                        ["slug" =>  $brandSlug]
                    );

                    $categoryName = $row[13];

                    if($categoryName == "Printer/PlotterSupplies"){
                        $categoryName = "Printer/Plotter Supplies";
                    }

                    $categorySlug = str_replace("-", "", $row[13]);
                    $categorySlug = str_replace(" ", "-", $categorySlug);
                    $mainCategory = Category::firstOrCreate(
                        ['name' => $row[13]],
                        ["slug" =>  $categorySlug]
                    );

                    $categorySlug = str_replace("-", "", $row[14]);
                    $categorySlug = str_replace(" ", "-", $categorySlug);
                    $subCategory = Category::firstOrCreate(
                        ['name' => $row[14]],
                        ["slug" =>  $categorySlug, "parent_id" => $mainCategory->id]
                    );


                    $slug = str_replace(" ", "-", $row[1]);
                    $slug = str_replace("/", "-", $slug); 
                    if(Product::where('slug', $slug)->count() > 0){
                        $slug = $slug."-".uniqid();
                    }

                    if(Product::where("ingram_part_number", $row[0])->count() <= 0){

                        $product = new Product;
                        $product->name = $row[1];
                        $product->sub_title = $row[1]; 
                        $product->sku = $row[2]; 
                        $product->brand_id = $brand->id;
                        $product->category_id = $subCategory->id;
                        $product->slug = $slug;
                        $product->picture = "";
                        $product->description = "";
                        $product->data_source_id = 2;
                        $product->price = 0;
                        $product->weight = $row[4]."-".$row[10];
                        $product->dimenssions = $row[7]." * ".$row[8]." * ".$row[6]."-".$row[9];
                        $product->external_price = $row[11];
                        $product->currency = $row[12];
                        $product->ingram_part_number = $row[0];
                        $product->save(); 

                    }

                       

                        //dd($product);
                    
                }
                $index++;
            }

        }catch(\Exception $e){
            dd($e->getMessage(), $e->getLine());
        }
    }
}
