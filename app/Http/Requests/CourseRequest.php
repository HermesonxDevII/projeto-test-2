<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        //return dd($this->request);

        $rules = [
            'course.name' => ['required', 'string', 'max:255'],
            'course.link' => ['nullable', 'max:255', 'regex:/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/'],
            'course.type' => ['required', 'between:1,2'],
            //'course.description' => ['required', 'max:950'],
            'course.module_id' => ['required', 'integer', 'exists:modules,id'],
            'course.classroom_id' => ['required', 'integer', 'exists:classrooms,id'],
            'course.teacher_id' => ['required', 'integer', 'exists:users,id'],
            'course.recorded_at' => ['required', 'date_format:Y/m/d', 'before:tomorrow'],
            'materials.*' => ['mimes:pdf,doc,docx,odt,ppt,pptx,odp,xls,xlsx,ods,jpg,jpeg,png,gif,webm,webp,svg,mp4,mov,3gp,avi,mkv', 'max:51200'],
        ];

        if ($this->filled('course.embed_code')) {
            $rules['course.embed_code.max'] = ['max:500'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'course.name.required' => 'O campo Título é obrigatório.',
            'course.name.string' => 'Valor inválido.',
            'course.name.max' => 'O campo Título deve conter no máximo 255 caracteres.',
            'course.link.required' => 'O campo Link é obrigatório.',
            'course.link.max' => 'O campo Link deve conter no máximo 255 caracteres.',
            'course.link.regex' => 'O Link deve ser válido.',
            'course.embed_code.max' => 'O Link Genially deve conter no máximo 500 caracteres.',
            'course.type.required' => 'O campo Tipo é obrigatório.',
            'course.type.between' => 'Valor inválido.',
            //'course.description.required' => 'O campo Descrição é obrigatório.',
            //'course.description.max' => 'O campo descrição deve conter no máximo 950 caracteres.',
            'course.module_id.required' => 'O campo Módulo é obrigatório.',
            'course.module_id.integer' => 'Valor inválido.',
            'course.module_id.exists' => 'Valor inválido.',
            'course.classroom_id.required' => 'O campo Turma é obrigatório.',
            'course.classroom_id.integer' => 'Valor inválido.',
            'course.classroom_id.exists' => 'Valor inválido.',
            'course.teacher_id.required' => 'O campo Professor campo é obrigatório.',
            'course.teacher_id.integer' => 'Valor inválido.',
            'course.teacher_id.exists' => 'Valor inválido.',
            'course.recorded_at.required' => 'O campo data de gravação é obrigatório.',
            'course.recorded_at.date_format' => 'O campo data de gravação deve ser valido.',
            'course.recorded_at.before' => 'O campo data de gravação deve ser valido.',
            'materials.*.mimes' => 'Arquivo inválido, você deve enviar um arquivo de imagem, vídeo, documento ou apresentação.',
            'materials.*.max' => 'O arquivo deve ser menor que 50MB.'
        ];
    }
}
