<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablecimientoFormRequest extends FormRequest
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
            'nombre' =>  'required|max:60',
            'ubicacion' =>  'required|max: 100',
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => ' El campo nombre es requerido',
            'ubicacion.required' => ' El campo ubicación es requerido',
        ];
    }
}
