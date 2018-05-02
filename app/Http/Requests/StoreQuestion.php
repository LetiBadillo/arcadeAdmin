<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestion extends FormRequest
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
            'subject_id' => 'required|integer',
            'options' => 'required|array',
            'question' => 'required|string',
            'author_id' => 'required|integer',
            'answer' => 'required|string',
            'difficulty' => 'required|integer',
        ];
    }
    public function messages()
{
    return [
        'subject_id.required' => 'El nombre de la materia es requerido.',
        'subject_id.integer' => 'Ese formato no es compatible.',
        'options.required'  => 'Las opciones son requeridas requerida.',
        'options.array'  => 'Ese formato no es compatible.',
        'question.string'  => 'Ese formato no es compatible.',
        'question.required'  => 'La pregunta es requerida.',
        'author_id.string'  => 'Ese formato no es compatible.',
        'author_id.required'  => 'El autor es requerido.',
        'answer.string'  => 'Ese formato no es compatible.',
        'answer.required'  => 'La respuesta es requerida.',
        'difficulty.integer'  => 'Ese formato no es compatible.',
        'difficulty.required'  => 'La dificultad es requerida.',
    ];
}
}
