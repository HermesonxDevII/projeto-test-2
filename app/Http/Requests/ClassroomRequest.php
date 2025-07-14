<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClassroomRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        $rules = [
            'classroom.name' => ['required', 'string' ,'max:255'],
            'classroom.description' => ['max:950'],
            'classroom.thumbnail' => ['mimes:jpg,jpeg,png', 'max:650'],
        ];

        if ($this->filled('edit'))
        {
            foreach($this->input('edit.schedules') as $key => $val)
            {
                $rules["edit.course.{$key}.name"] = ['required', 'string'];
                $rules["edit.course.{$key}.teacher_id"] = ['required', 'integer','exists:users,id'];
                $rules["edit.course.{$key}.start"] = ['required'];
                $rules["edit.course.{$key}.end"] = ['required', 'after:edit.course.' . $key . '.start'];
                $rules["edit.schedules.{$key}"] = ['array', 'required'];

                if ($this->filled("edit.course.{$key}.link"))
                {
                    $rules["edit.course.{$key}.link"] = ['regex:/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/'];
                }
            }
        }

        if ($this->filled('create'))
        {
            foreach($this->input('create.schedules') as $key => $val)
            {
                $rules["create.course.{$key}.name"] = ['required', 'string'];
                $rules["create.course.{$key}.link"] = ['nullable', 'max:255', 'regex:/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/'];
                $rules["create.course.{$key}.teacher_id"] = ['required', 'integer','exists:users,id'];
                $rules["create.course.{$key}.start"] = ['required'];
                $rules["create.course.{$key}.end"] = ['required', 'after:create.course.' . $key . '.start'];
                $rules["create.schedules.{$key}"] = ['array', 'required'];

                if ($this->filled("create.course.{$key}.link"))
                {
                    $rules["create.course.{$key}.link"] = ['regex:/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()!@:%_\+.~#?&\/\/=]*)/'];
                }
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'classroom.name.required' => 'O campo Nome é obrigatório.',
            'classroom.name.string' => 'O campo Nome deve conter apenas letras.',
            'classroom.name.max' => 'O campo Nome deve possuir no máximo 255 caracteres.',
            'classroom.description.max' => 'O campo Descrição deve possuir no máximo 950 caracteres.',
            'classroom.status.required' => 'O campo Status é obrigatório.',
            'classroom.thumbnail.required' => 'O campo Thumbnail é obrigatório',
            'classroom.thumbnail.max' => 'O campo Thumbnail deve possuír até 650 KBs',
            'classroom.thumbnail.mimes' => 'O campo Thumbnail deve ser um JPG, JPEG ou PNG',
            'status.boolean' => 'O campo Status deve ser Ativado ou Desativado.'
        ];

        if ($this->filled('edit'))
        {
            foreach($this->input('edit.schedules') as $key => $val)
            {
                $messages["edit.course.{$key}.start.required"] = 'O campo Início é obrigatório.';
                $messages["edit.course.{$key}.end.required"] = 'O campo Fim é obrigatório.';
                $messages["edit.course.{$key}.link.regex"] = 'O Link deve ser válido.';
                $messages["edit.course.{$key}.end.after"] = 'A hora de fim deve ser maior do que a de início.';
                $messages["edit.course.{$key}.name.required"] = 'O campo Nome da aula é obrigatório.';
                $messages["edit.course.{$key}.name.string"] = 'O campo Nome da aula deve conter apenas texto.';
                $messages["edit.course.{$key}.teacher_id.required"] = 'O campo Professor é obrigatório.';
                $messages["edit.course.{$key}.teacher_id.integer"] = 'O campo Professor deve ser válido.';
                $messages["edit.course.{$key}.teacher_id.exists"] = 'O campo Professor deve ser válido.';
            }
        } else
        {
            $messages['edit.schedules.required'] = 'As agendas são obrigatórias.';
        }

        if ($this->filled('create'))
        {
            foreach($this->input('create.schedules') as $key => $val)
            {
                $messages["create.course.{$key}.start.required"] = 'O campo Início é obrigatório.';
                $messages["create.course.{$key}.end.required"] = 'O campo Fim é obrigatório.';
                $messages["create.course.{$key}.end.after"] = 'A hora de fim deve ser maior do que a de início.';
                $messages["create.course.{$key}.name.required"] = 'O campo Nome da aula é obrigatório.';
                $messages["create.course.{$key}.name.string"] = 'O campo Nome da aula deve conter apenas texto.';
                $messages["create.course.{$key}.link.regex"] = 'O Link deve ser válido.';
                $messages["create.course.{$key}.teacher_id.required"] = 'O campo Professor é obrigatório.';
                $messages["create.course.{$key}.teacher_id.integer"] = 'O campo Professor deve ser válido.';
                $messages["create.course.{$key}.teacher_id.exists"] = 'O campo Professor deve ser válido.';
            }
        } else
        {
            $messages['create.schedules.required'] = 'As agendas são obrigatórias.';
        }

        return $messages;
    }
}
