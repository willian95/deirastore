<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ssh2_connect;
use App\Imports\IngramImport;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    function update(){
        ini_set("memory_limit","500M");
        ini_set('max_execution_time', 0);
        $connection = ssh2_connect('200.27.164.195', 22);
        ssh2_auth_password($connection, 'root', 'Terminal*1');
        $stream = ssh2_exec($connection, 'unzip /home/ftpingram/CLPriceFileDeira.csv.zip');
        //ssh2_scp_recv($connection, '/home/ftpingram/CLPriceFileDeira.csv.zip', public_path('/')."CLPriceFileDeira.csv.zip");
        dd($stream);
        ob_end_clean();
        system('unzip CLPriceFileDeira.csv.zip');

        //Excel::import(new IngramImport, 'CLPriceFileDeira.csv');

    }
}
