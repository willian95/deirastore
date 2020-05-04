<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchase extends FormRequest
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
            "shoppingPrice" => "numeric",
            "amount" => "integer"
        ];
    }

    public function messages(){
        return [

            "shoppingPrice.numeric" => "Precio debe ser un número",
            "amount.integer" => "Cantidad debe ser un número entero"

        ];
    }

}
