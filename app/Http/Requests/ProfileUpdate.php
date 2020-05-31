<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdate extends FormRequest
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
            "name" => "required",
            "lastname" => "required",
            "genre" => "required",
            "birthDate" => "required|date",
            "phoneNumber" => "required",
            "rut" => "required",
            "address" => "required"
        ];
    }

    public function messages(){
        return[

            "name.required" => "Nombre es requerido",
            "lastname.required" => "Apellido es requerido",
            "genre.required" => "Género es requerido",
            "birthDate.required" => "Fecha de nacimiento es requerida",
            "birthDate.date" => "Fecha de nacimiento debe ser una fecha",
            "phoneNumber.required" => "Teléfono es requerido",

        ];
    }
}
