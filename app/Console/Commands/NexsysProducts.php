<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Category;
use Carbon\Carbon;
use App\Brand;
use App\Product;

class NexsysProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:nexsys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualización y creación de los productos de Nexsys';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);
        //$params = ["encoding" => "UTF-8", "verifypeer" => false, "verifyhost" => false];
        $mark = "ADATA";
        $url = "https://app.nexsysla.com/nexsysServiceSoap/NexsysServiceSoap?wsdl";

        try{
        
            $client = new \SoapClient($url);
            $products = $client->StoreProductByMarks(["Marks" => $mark, "WSClient"=> ["country" => "Chile", "username" => "78198200"]]);
            //dd($products);
            $brandSlug = str_replace(" ", "-", $mark);
            $brand = Brand::firstOrCreate(
                ['name' => $mark],
                ["slug" =>  $brandSlug]
            );

            foreach($products as $product){
                foreach($product as $value){
                    
                    if(is_string($value->category)){

                        $fullCategory = substr($value->category, 3);

                        $categories = explode('>', $fullCategory);

                        $index = 0;
                        $model = null;

                        if(count($categories) > 2){
                            array_pop($categories);
                        }

                        foreach($categories as $category){
                          
                            $string = trim($category);
                            $slug = str_replace(" ", "-", $string);
                            $slug = str_replace("/", "-", $slug);

                            if($index == 1){

                                $previousSlug = str_replace(" ", "-", trim($categories[$index - 1]));
                                $previousSlug = str_replace("/", "-", $previousSlug);
                                
                                
                                $previousCategory = Category::where('slug', $previousSlug)->first();
                                if(Category::where('slug', $slug)->where('parent_id', $previousCategory->id)->count() == 0){
                                    $model = new Category;
                                    $model->name = $string;
                                    $model->slug = $slug;
                                    $model->parent_id = $previousCategory->id;
                                    $model->save();
                                }

                            }else{

                                $model = Category::firstOrCreate(
                                    ['name' => $string],
                                    ['slug' => $slug]
                                );

                            }
                            
                            $index++;

                        }

                        $productSlug = str_replace(" ", "-", $value->short_description);
                        $productSlug = str_replace("/", "-", $productSlug);
                        
                        $excluded_tax = false;
                        if($value->tax_excluded == "true")
                            $excluded_tax = true;

                        $amount = 0;
                        if($value->inventory != "null")
                            $amount = $value->inventory;
                        
                        Log::info('Sku: '.$value->sku);

                        $testProduct = Product::updateOrCreate(
                            ["sku" => $value->sku],
                            [
                                "category_id" => $model->id,
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
