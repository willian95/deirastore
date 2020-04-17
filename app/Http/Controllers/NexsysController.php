<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NexsysController extends Controller
{
    
    function index(){
        $params = ["encoding" => "UTF-8", "verifypeer" => false, "verifyhost" => false];
        $url = "https://app.nexsysla.com/nexsysServiceSoap/NexsysServiceSoap?wsdl";

        try{
            
            $client = new \SoapClient($url, $params);
            
            //dd($client->__getTypes());
            //dd($client->StoreProductByMarks(["Marks" => "ADATA", ""]));
            dd($client->StoreProductByMarks(["Marks" => "ADATA", "WSClient"=> ["country" => "Chile", "username" => "78198200"]]));
            
        }catch(\SoapFault $fault){
            dd($fault);
        }

    }

}
