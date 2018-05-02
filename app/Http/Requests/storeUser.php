<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeUser extends FormRequest
{
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
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'subjects' => 'required|array'
        ];
    }
    public function messages()
{
    return [
        'name.required' => 'Este campo es requerido.',
        'name.string' => 'Ese formato no es compatible.',
        'last_name.required'  => 'Este campo es requerido.',
        'last_name.integer'  => 'Ese formato no es compatible.',
        'email.required'  => 'Este campo es requerido.',
        'subjects.required'  => 'Este campo es requerido.',
        'subjects.integer'  => 'Ese formato no es compatible.'
    ];
}
}
