<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guest;

class UserController extends Controller
{
    
    function index(){

        return view('admin.users');

    }

    function guest(){

        return view('admin.guests');

    }

    function fetchRegisterd($page = 1){

        try{

            $offset = 20;
            $take = 20;

            $skip = ($page-1) * $take;

            $users = User::skip($skip)->take($take)->with("location", "commune")->get();
            $usersCount = User::count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount]);

        }catch(\Exception $e){

        }

    }

    function fetchGuest($page = 1){

        try{

            $offset = 20;
            $take = 20;

            $skip = ($page-1) * $take;

            $users = Guest::skip($skip)->take($take)->with("location", "commune")->get();
            $usersCount = Guest::count();

            return response()->json(["success" => true, "users" => $users, "usersCount" => $usersCount]);

        }catch(\Exception $e){

        }

    }

}
