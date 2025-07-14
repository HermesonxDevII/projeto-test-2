<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class AddStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        $rules = [
            'student.full_name' => ['required', 'string'],
            'student.grade_id' => ['required', 'integer'],
            'student.domain_language_id' => ['required', 'exists:App\Models\Language,id'],
            'student.avatar_id' => ['required', 'between:1,6'],
        ];

        if ($this->filled('student.email')) {
            $rules['student.email'] = [
                'required',
                'email',
                Rule::unique('students', 'email')->whereNull('deleted_at')
            ];
        }

        return $rules;
    }


    public function messages()
    {
        $messages = [
            'student.full_name.required' => 'O campo Nome é obrigatório.',
            'student.full_name.string' => 'O campo Nome deve conter apenas letras.',
            'student.email.unique' => 'Este E-Mail já está em uso.',
            'student.email.email' => 'O E-Mail deve ser válido.',
            'student.grade_id.required' => 'O campo Série é obrigatório.',
            'student.domain_language_id.required' => 'O campo Idioma é obrigatório.',
            'student.domain_language_id.exists' => 'O campo Idioma deve ser válido.',
            'student.avatar' => 'Escolha um Avatar.',
            'student.avatar' => 'O Avatar deve ser válido.',
        ];

        return $messages;
    }
}
