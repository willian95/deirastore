<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ssh2_connect;

class FileController extends Controller
{
    function update(){

        ini_set('max_execution_time', 0);
        $connection = ssh2_connect('200.27.164.195', 22);
        ssh2_auth_password($connection, 'root', 'Terminal*1');

        ssh2_scp_recv($connection, '/home/ftpingram/test.txt', "/test.txt");

    }
}
