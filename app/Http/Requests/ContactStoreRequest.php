<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            "phone" => "required"
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Email no puede estar vacío",
            "email.email" => "Email debe tener un formato correcto",
            "phone.required" => "Teléfono no puede estar vacío"
        ];
    }
}
