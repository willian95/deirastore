<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeatureStoreRequest extends FormRequest
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
            "feature" => "required",
            "description" => "required"
        ];
    }

    public function messages()
    {
        return [
            "feature.required" => "Característica es requerida",
            "description.required" => "Descripción es requerida"
        ];
    }
}
