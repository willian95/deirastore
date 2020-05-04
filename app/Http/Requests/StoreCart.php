<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCart extends FormRequest
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
            "amount" => "required|integer",
            "productId" => "required|integer"
        ];
    }

    public function messages(){
        return[

            "amount.required" => "Cantidad es requerida",
            "amount.integer" => "Cantidad debe ser un número entero",
        ];
    }
}
