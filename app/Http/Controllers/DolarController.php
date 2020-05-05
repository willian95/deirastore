<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\DolarPrice;

class DolarController extends Controller
{
    
    function index(){

        $client = new \GuzzleHttp\Client();
        $request = $client->request("GET", 'https://mindicador.cl/api/dolar');
        $response = json_decode($request->getBody());
        $value = $response->serie[0]->valor;

        DolarPrice::updateOrCreate(
            ["id" => 1],
            ["price" => $value]
        );

    }


}
