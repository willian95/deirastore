<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerStoreRequest extends FormRequest
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
            "image" => "required",
            "size" => "required",
            "location" => "required"
        ];
    }

    public function messages(){
        return[

            "image.required" => "Imagen es requerida",
            "size.required" => "Tamaño es requerido",
            "location.required" => "Lugar es requerido",

        ];
    }
}
