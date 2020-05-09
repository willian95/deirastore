<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactStoreRequest;
use App\Contact;

class ContactController extends Controller
{
    
    function store(ContactStoreRequest $request){

        try{

            $contact = new Contact;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->save();

            return response()->json(["success" => true, "msg" => "Excelente, te notificaremos cuando el sitio esté listo"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Lo sentimos, estamos presentando problemas tecnicos"]);

        }

    }

}
