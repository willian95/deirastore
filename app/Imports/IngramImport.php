<?php

namespace App\Imports;

use App\Product;
use App\Brand;
use App\Category;
//use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

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
        $index = 0;
        foreach ($rows as $row) 
        {
            //dd($row);
            if($index > 0){
                //dd(substr($row[0], 11, strlen($row[0])));
                $brandSlug = str_replace("-", "", $row[7]);
                $brandSlug = str_replace(" ", "-", $brandSlug);
                $brand = Brand::firstOrCreate(
                    ['name' => $row[7]],
                    ["slug" =>  $brandSlug]
                );

                $categorySlug = str_replace("-", "", $row[87]);
                $categorySlug = str_replace(" ", "-", $categorySlug);
                $mainCategory = Category::firstOrCreate(
                    ['name' => $row[87]],
                    ["slug" =>  $categorySlug]
                );

                $categorySlug = str_replace("-", "", $row[89]);
                $categorySlug = str_replace(" ", "-", $categorySlug);
                $subCategory = Category::firstOrCreate(
                    ['name' => $row[89]],
                    ["slug" =>  $categorySlug, "category_id" => $mainCategory->id]
                );

                $slug = str_replace(" ", "-", $row[1]);
                if(Product::where('slug', $slug)->count() > 0){
                    $slug = $slug."-".uniqid();
                }

                if(Product::where('ingram_part_number', substr($row[0], 11, strlen($row[0])))->count() > 0){
                    //dd($slug);
                    $product = Product::where('ingram_part_number', substr($row[0], 11, strlen($row[0])))->first();
                    $product->name = $row[1];
                    $product->sub_title = $row[1]; 
                    $product->sku = $row[3]; 
                    $product->brand_id = $brand->id;
                    $product->category_id = $subCategory->id;
                    $product->slug = $slug;
                    $product->price = 0;
                    $product->weight = $row[9]."-".$row[28];
                    $product->dimenssions = $row[25]." * ".$row[26]." * ".$row[24]."-".$row[27];
                    $product->external_price = $row[56];
                    $product->currency = $row[68];
                    $product->update();    
                    //dd($product);
                }
            }
            $index++;
        }
    }
}
