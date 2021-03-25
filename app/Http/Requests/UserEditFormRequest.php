<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'rol' => 'required',
            'password' => 'min:6',
            
        ];
    }
    public function messages()
    {
        return [
            'name.required' => ' El campo nombre es requerido',
            'rol.required' => ' Seleccione un rol',
            'password.min' => ' El password debe contener al menos 6 caracteres',    
        ];
    }
}
