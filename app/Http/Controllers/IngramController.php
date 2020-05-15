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
        Excel::import(new IngramImport, 'CLPriceFileDeira.csv', "ingram");
        dd("done");
        //return redirect('/')->with('success', 'All good!');
    }
}
