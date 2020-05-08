<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    
    function store(Request $request){

        $contact = new Contact;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->save();

        return response()->json(["msg" => "Excelente, te notificaremos cuando el sitio esté listo"]);

    }

}
