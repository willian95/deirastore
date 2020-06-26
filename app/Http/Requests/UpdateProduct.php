<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
            //"price" => "required|numeric",
            //"subPrice" => "required|numeric",
            "categoryId" => "required",
            "description" => "required",
            "brandId" => "required|integer" 
        ];
    }

    public function messages(){
        return[

            "name.required" => "Nombre es requerido",
            //"price.required" => "Precio es requerido",
            //"price.numeric" => "Precio debe ser un número",
            //"subPrice.required" => "Sub-precio es requerido",
            //"subPrice.numeric" => "Sub-precio debe ser un número",
            "categoryId.required" => "Debe elegir una categoría",
            "description.required" => "Descripción es requerida",
            "brandId.required" => "Marca es requerida",
            "brandId.integer" => "Debe elegir una marca válida"

        ];
    }
}
