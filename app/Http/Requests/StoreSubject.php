<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubject extends FormRequest
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
            'subject_name' => 'required|string',
            'subject_branch_id' => 'required|integer',
            'level' => 'required|integer',
            'user_id' => 'array',
        ];
    }
    public function messages()
{
    return [
        'subject_name.required' => 'El nombre de la materia es requerido.',
        'subject_name.string' => 'Ese formato no es compatible.',
        'subject_branch_id.required'  => 'La rama de la materia es requerida.',
        'subject_branch_id.integer'  => 'Ese formato no es compatible.',
        'level.integer'  => 'Ese formato no es compatible.',
        'level.required'  => 'Selecciona el nivel escolar.',
        'user_id.array'  => 'Ese formato no es compatible.'
    ];
}
}
