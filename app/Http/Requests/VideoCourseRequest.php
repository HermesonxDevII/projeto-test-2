<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VideoCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        return [
            'video_course.title' => ['required', 'string', 'max:255'],
            'video_course.description' => ['nullable', 'string', 'max:300'],
            'video_course.thumbnail' => ['mimes:jpg,jpeg,png', 'max:650'],
            'video_course.cover' => ['mimes:jpg,jpeg,png', 'max:650'],
            'video_course_modules.*' => ['nullable'],
            'video_course.teacher_access' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'video_course.title' => 'Título',
            'video_course.description' => 'Descrição',
            'video_course.thumbnail' => 'Thumbnail',
            'video_course.cover' => 'Capa interna',
            'video_course_modules.*' => 'Módulos',
            'video_course.teacher_access' => 'Acesso aos professores'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'Valor inválido.',
            // 'array' => 'Valor inválido.',
            'max' => 'O campo :attribute deve conter no máximo :max caracteres.',            
            'mimes' => 'O campo Thumbnail deve ser um JPG, JPEG ou PNG',
            'video_course.thumbnail.max' => 'O campo Thumbnail deve possuír até 650 KBs',
            'video_course.cover.max' => 'O campo Thumbnail deve possuír até 650 KBs',
        ];
    }
}
