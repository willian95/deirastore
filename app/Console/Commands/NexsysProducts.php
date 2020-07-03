<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Category;
use Carbon\Carbon;
use App\Brand;
use App\Product;

use ssh2_connect;
use App\Imports\IngramImport;
use Maatwebsite\Excel\Facades\Excel;

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

    function excelAction(){
        
    }

    public function handle()
    {
        ini_set("memory_limit","500M");
        ini_set('max_execution_time', 0);
        //$params = ["encoding" => "UTF-8", "verifypeer" => false, "verifyhost" => false];
        Log::info("monster alive");
        try{

            $connection = ssh2_connect('200.27.164.195', 22);
            ssh2_auth_password($connection, 'root', 'Terminal*1');

            ssh2_scp_recv($connection, '/home/ftpingram/CLPriceFileDeira.csv', public_path('/')."CLPriceFileDeira.csv");
            //ssh2_scp_recv($connection, '/home/ftpingram/CLPriceFileDeira.csv.zip', public_path('/')."CLPriceFileDeira.csv.zip");
            //ob_end_clean();
            //system('unzip CLPriceFileDeira.csv.zip');
            sleep(10);
            Excel::import(new IngramImport, public_path('/').'CLPriceFileDeira.csv');

            Log::info("reading done");

        }catch(\Exception $e){
            Log::info($e->getMessage().", ln: ".$e->getLine());
        }

        /*$url = "https://app.nexsysla.com/nexsysServiceSoap/NexsysServiceSoap?wsdl";
        $marks = [
            "3nStar",
            "Adata",
            "Adobe",
            "AOC",
            "APC",
            "Arcserve",
            "BIXOLON",
            "Corel",
            "Datalogic",
            "Epson Escaner",
            "Epson Gran Formato",
            "Epson Impresión",
            "Epson Pos",
            "Epson Proyectores",
            "HP Impresión Consumo",
            "HP Impresión Corporativo",
            "HP Pcs Empresariales",
            "HP Portatiles Empresariales",
            "HP POS",
            "HP Workstation",
            "Jabra",
            "Kaspersky Consumo",
            "Kaspersky Corporativo", 
            "Lenovo Corporativo",
            "Lenovo Servidores",
            "Lenovo Workstation", 
            "LG",
            "Liferay",
            "McAfee",
            "OKI",
            "Poly",
            "RedHat",
            "Sophos",
            "Wacom",
            "Xerox"
        ];

        foreach($marks as $mark){
            Log::info($mark);
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
                        
                            $index = 0;
                            $model = null;


                            $productSlug = str_replace(" ", "-", $value->short_description);
                            $productSlug = str_replace("/", "-", $productSlug);
                            
                            $excluded_tax = false;
                            if($value->tax_excluded == "true")
                                $excluded_tax = true;

                            $amount = 0;
                            if($value->inventory != "null")
                                $amount = $value->inventory;

                            if(Product::where("sku", $value->sku)->count() <= 0){

                                Product::create(
                                    [
                                        "sku" => $value->sku,
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

                            }else{

                                $product = Product::where("sku", $value->sku)->where("data_source_id", 1)->first();
                                if($product){
                                    $product->amount = $amount;
                                    $product->external_price = floatval($value->price);
                                    $product->update();
                                }

                            }

                    }
                }

                //return true;

            }catch(\SoapFault $fault){
                Log::info($fault);
            }
        }*/
    
    }
}
