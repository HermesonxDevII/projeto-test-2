<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VideoCourseClassRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        $rules = [
            'class.furigana_title' => ['nullable', 'string', 'max:255'],
            'class.original_title' => ['required', 'string', 'max:255'],
            'class.translated_title' => ['nullable', 'string', 'max:255'],
            'class.link' => ['nullable', 'max:255', 'regex:/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/'],
            'class.duration' => ['nullable', 'regex:/(?:[0-9]{2}):(?:[0-5]\d)(:?:[0-5]\d)?/'],
            'class.description' => ['nullable', 'string', 'max:2000'],
            'class.video_course_module_id' => ['required', 'integer', 'exists:video_course_modules,id'],
            'class.teacher' => ['nullable', 'string', 'max:255'],
            'class.thumbnail' => ['mimes:jpg,jpeg,png', 'max:650'],
            'materials.*' => ['mimes:pdf,doc,docx,odt,ppt,pptx,odp,xls,xlsx,ods,jpg,jpeg,png,gif,webm,webp,svg,mp4,mov,3gp,avi,mkv', 'max:51200'],
            'deleted_files' => ['nullable']
        ];

        if ($this->filled('course.embed_code')) {
            $rules['course.embed_code.max'] = ['max:500'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'class.duration.regex' => 'O campo duração está com formato inválido.',
            'class.furigana_title.required' => 'O campo Pronúncia é obrigatório.',
            'class.furigana_title.string' => 'Valor inválido.',
            'class.furigana_title.max' => 'O campo Pronúncia deve conter no máximo :max caracteres.',
            'class.original_title.required' => 'O campo Título é obrigatório.',
            'class.original_title.string' => 'Valor inválido.',
            'class.original_title.max' => 'O campo Título deve conter no máximo :max caracteres.',
            'class.translated_title.required' => 'O campo Tradução em português é obrigatório.',
            'class.translated_title.string' => 'Valor inválido.',
            'class.translated_title.max' => 'O campo Tradução em português deve conter no máximo :max caracteres.',
            'class.link.required' => 'O campo Link é obrigatório.',
            'class.link.max' => 'O campo Link deve conter no máximo :max caracteres.',
            'class.link.regex' => 'O Link deve ser válido.',
            'class.duration.required' => 'O campo Duração é obrigatório.',
            'class.duration.regex' => 'O Duração deve ser no formato h:m:s.',
            'class.description.required' => 'O campo Descrição é obrigatório.',
            'class.description.max' => 'O campo Descrição deve conter no máximo :max caracteres.',
            'class.video_course_module_id.required' => 'O campo Módulo é obrigatório.',
            'class.video_course_module_id.integer' => 'Valor inválido.',
            'class.video_course_module_id.exists' => 'Valor inválido.',
            'class.teacher.required' => 'O campo Professor é obrigatório.',
            'class.teacher.string' => 'Valor inválido.',
            'class.teacher.max' => 'O campo Professor deve conter no máximo :max caracteres.',
            'classroom.thumbnail.required' => 'O campo Thumbnail é obrigatório',
            'classroom.thumbnail.max' => 'O campo Thumbnail deve possuír até 650 KBs',
            'classroom.thumbnail.mimes' => 'O campo Thumbnail deve ser um JPG, JPEG ou PNG',
            'materials.*.mimes' => 'Arquivo inválido, você deve enviar um arquivo de imagem, vídeo, documento ou apresentação.',
            'materials.*.max' => 'O arquivo deve ser menor que 50MB.'
        ];
    }
}
