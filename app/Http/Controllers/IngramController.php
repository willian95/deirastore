<?php

namespace App\Http\Controllers;
use App\Imports\IngramImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class IngramController extends Controller
{
    public function import() 
    {
        ini_set('max_execution_time', 0);
        try{

            Excel::import(new IngramImport, 'CLPriceFileDeira.csv', "ingram");
            dd("done");

        }catch(\Exception $e){
            dd($e->getMessage(), $e->getLine());
        }
        //return redirect('/')->with('success', 'All good!');
    }
}
