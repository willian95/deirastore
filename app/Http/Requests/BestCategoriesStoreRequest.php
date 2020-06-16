<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestCategoriesStoreRequest extends FormRequest
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
            "category" => "required|exists:categories,id|unique:best_categories,category_id"
        ];
    }

    public function messages(){

        return[
            "category.required" => "Categoría es requerida",
            "category.exists" => "Categoría elegida no es válida",
            "category.unique" => "Esta categoría ya está seleccionada"
        ];

    }
}
