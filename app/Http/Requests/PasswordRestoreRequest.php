<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRestoreRequest extends FormRequest
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
            "password" => "required|confirmed",
            "recovery_hash" => "required"
        ];
    }

    public function messages(){
        return[

            "password.required" => "Contraseña es requerida",
            "password.confirmed" => "Contraseñas no coinciden",
            "recovery_hash.required" => "No posee un token de verificación",

        ];
    }
}
