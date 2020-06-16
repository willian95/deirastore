<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestStoresStoreRequest extends FormRequest
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
            "brand" => "required|exists:brands,id|unique:best_stores,brand_id"
        ];
    }

    public function messages(){

        return[
            "brand.required" => "Marca es requerida",
            "brand.exists" => "Marca elegida no es válida",
            "brand.unique" => "Esta marca ya está seleccionada"
        ];

    }
}
