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
            $counterRow = 0;
            $nuevos = 0;
            $actualizados= 0;
            foreach ($rows as $row) 
            {
                

                if($index > 0 && $row[0] != ""){
                    
                    //if($row[16] > 0){
                        /*echo $row[87]." - ".$row[3]."<br>";
                        if($row[87] == ""){
                            dd($row);
                        }*/
                        //dd(substr($row[0], 11, strlen($row[0])));
                        $brandSlug = str_replace("-", "", $row[3]);
                        $brandSlug = str_replace(" ", "-", $brandSlug);
                        $brand = Brand::firstOrCreate(
                            ['name' => $row[7]],
                            ["slug" =>  $brandSlug]
                        );

                        $categoryName = $row[87];
                        
                        if($categoryName == "Printer/PlotterSupplies"){
                            $categoryName = "Printer/Plotter Supplies";
                        }

                        if($categoryName == "Computer Cases &Accessories" || $categoryName == "ComputerCases & Accessories" || $categoryName == "Computer Cases& Accessories"){
                            $categoryName = "Computer Cases & Accessories";
                        }

                        if($categoryName == "Notebooks& Tablets"){
                            $categoryName = "Notebooks & Tablets";
                        }

                        if($categoryName == "USB & FirewireConnectivity"){
                            $categoryName = "USB & Firewire Connectivity";
                        }

                        

                        $categorySlug = str_replace("-", "", $row[87]);
                        $categorySlug = str_replace(" ", "-", $categorySlug);
                        $categorySlug = str_replace("/", "-", $categorySlug);
                        $mainCategory = Category::firstOrCreate(
                            ['name' => $row[87]],
                            ["slug" =>  $categorySlug]
                        );

                        $categorySlug = str_replace("-", "", $row[88]);
                        $categorySlug = str_replace(" ", "-", $categorySlug);
                        $categorySlug = str_replace("/", "-", $categorySlug);
                        $subCategory = Category::firstOrCreate(
                            ['name' => $row[88]],
                            ["slug" =>  $categorySlug, "parent_id" => $mainCategory->id]
                        );


                        $slug = str_replace(" ", "-", $row[1]);
                        $slug = str_replace("/", "-", $slug); 
                        if(Product::where('slug', $slug)->count() > 0){
                            $slug = $slug."-".uniqid();
                        }
                        
                        if(Product::where("sku", $row[3])->count() <= 0){

                            $product = new Product;
                            $product->name = $row[1];
                            $product->sub_title = $row[1]; 
                            $product->sku = $row[3]; 
                            $product->brand_id = $brand->id;
                            $product->category_id = $subCategory->id;
                            $product->slug = $slug;
                            $product->picture = "";
                            $product->description = "";
                            $product->data_source_id = 2;
                            $product->price = 0;
                            $product->amount = $row[16];
                            $product->weight = "0";
                            $product->dimenssions = "0";
                            $product->external_price = $row[56];
                            $product->currency = $row[68];
                            $product->ingram_part_number = $row[0];
                            $product->save(); 
                            $nuevos++;

                        }else{

                            $product = Product::where("sku", $row[3])->first();
                            $product->amount = $row[16];
                            $product->external_price = $row[56];
                            $product->update();
                            $actualizados++;

                        }

                    //}
                    $counter++;
                    //dd($product);
                    
                }
                $index++;
            }

        }catch(\Exception $e){
            dd($e->getMessage(), $e->getLine());
        }
    }
}
