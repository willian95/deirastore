<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HighlightedProductStore extends FormRequest
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
            "product" => "required|unique:highlighted_products,product_id"
        ];
    }

    public function messages()
    {
        return [
            "product.unique" => "Este producto ya ha sido seleccionado",
            "product.required" => "Debe seleccionar un producto"
        ];
    }
}
