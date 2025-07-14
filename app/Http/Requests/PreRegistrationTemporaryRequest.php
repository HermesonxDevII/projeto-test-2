<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreRegistrationTemporaryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [            
            'guardian_name' => 'required|string|max:255',
            'guardian_email' => 'required|email|max:255',
            'guardian_phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'work_company' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'student_class' => 'required|string|max:255',
            'student_language' => 'required|string|max:255',
            'student_japan_arrival' => 'required|string|max:255',
            'student_has_difficult' => 'required|string|max:255',
            'student_difficult_in_class' => 'nullable|string|max:10000',
        ];
    }

    public function messages()
    {
        return [            
            'student_difficult_in_class.max' => 'O campo "Quais os maiores problemas/dificuldades que seu filho(a) está enfrentando nos estudos da escola japonesa?" não deve exceder :max caracteres.',            
            'guardian_email.email' => 'O campo email do responsável deve ser um e-mail válido'
        ];
    }
}
