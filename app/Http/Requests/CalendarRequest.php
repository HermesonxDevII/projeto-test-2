<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'calendar.title' => ['required', 'string'],
            'calendar.embed_code' => ['required', 'max:500'],
        ];

        $rules["calendar.grade"] = ['array', 'required'];

        if ($this->filled('calendar.grade')){
            $gradeSelected=false;
            foreach($this->input('calendar.grade') as $value){
                if(isset($value["grade_id"])){
                    $gradeSelected=true;
                }
            }
            if(!$gradeSelected){
                $rules["calendar.grade.grade_id"] = ['required'];
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'calendar.title.string'   => 'O campo Título não é válido.',
            'calendar.title.required' => 'O campo Título é obrigatório.',
            'calendar.grade.required' => 'O campo Série é obrigatório.',
            'calendar.grade.grade_id.required' => 'O campo Série é obrigatório.',
            'calendar.grade.array'    => 'O campo Série não é valido.',
            'calendar.embed_code.required' => 'O campo Embed link é obrigatório.',
            'calendar.embed_code.max' => 'O campo Embed link deve possuir no máximo 500 caracteres.',
        ];

        return $messages;
    }
}
