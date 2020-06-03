<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "required|email",
            "name" => "required",
            "location" => "required",
            "address" => "required"
        ];
    }

    public function messages(){
        return[

            "email.required" => "Correo es requerido",
            "email.email" => "Correo debe ser un correo válido",
            "name.required" => "Nombre es requerido",
            "location.required" => "Debe elegir una región",
            "address.required" => "Dirección es requerida"

        ];
    }
}
