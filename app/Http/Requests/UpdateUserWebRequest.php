<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserWebRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => ['required','max:255'  , Rule::unique('users')->ignore($this->route('user'))],
        ];
        
    }


    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no debe exceder los 255 caracteres.',

            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'email.max' => 'El campo correo electrónico no debe exceder los 255 caracteres.',];
    }

}
