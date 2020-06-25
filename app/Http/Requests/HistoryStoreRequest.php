<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryStoreRequest extends FormRequest
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
            "type" => "required",
            "percentage" => "required|min:0"
        ];
    }

    public function message(){

        return[
            "type.required" => "Debe elegir un tipo",
            "percentage.required" => "El porcentage es requerido",
            
        ];

    }

}
