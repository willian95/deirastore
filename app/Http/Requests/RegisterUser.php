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
            "password" => 'required|confirmed',
            /*'phoneNumber' => 'required',
            'genre' => 'required',*/
            "recaptcha" => "recaptcha",
            /*"location" => "required",
            "comune_id" => "required",
            "street" => "required",
            "number" => "required"*/
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
            "password.required" => "Contraseña es requerida",
            "password.confirmed" => "Contraseñas no coinciden",
            /*"phoneNumber.required" => "Teléfono es requerido",
            "genre.required" => "Género es requerido",
            "address.required" => "Dirección es requerida",*/
            "recaptcha.recaptcha" => "Captcha no válido",
            /*"location.required" => "Región es requerida",
            "comune_id.required" => "Comuna es requerida",
            "street.required" => "Calle es requerida",
            "number.required" => "Númeroes requerido"*/
        ];
    }
}
