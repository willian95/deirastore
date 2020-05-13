<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
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
            'email' => 'required|unique:users|email',
            'rut' => 'required|unique:users',
            'lastname' => "required",
            "name" => 'required',
            "password" => 'required',
            'phoneNumber' => 'required',
            'genre' => 'required',
            "address" => "required",
            "recaptcha" => "recaptcha"
        ];
    }

    public function messages(){
        return[

            "email.required" => "Correo es requerido",
            "email.email" => "Correo debe ser un correo válido",
            "email.unique" => "Correo ya está registrado",
            'lastname.required' => "Apellidos son requeridos",
            "rut.required" => "RUT es requerido",
            "rut.unique" => "RUT ya está  registrado",
            "name.required" => "Nombre es requerido",
            "password.required" => "Clave es requerida",
            "phoneNumber.required" => "Teléfono es requerido",
            "genre.required" => "Género es requerido",
            "address.required" => "Dirección es requerida",
            "recaptcha.recaptcha" => "Captcha no válido"
        ];
    }
}
