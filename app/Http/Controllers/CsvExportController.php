<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Excel;

class CsvExportController extends Controller
{
    
    function index(){
        ini_set('max_execution_time', 0);
        return Excel::download(new ProductsExport, 'products.xlsx');

    }

}
