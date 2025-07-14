<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        $rules = [
            'student.full_name' => ['required', 'string'],
            'student.grade_id' => ['integer'],
            'student.domain_language_id' => ['exists:App\Models\Language,id'],
            'student.avatar_id' => ['required', 'between:1,6'],
            'student.expires_at' => ['nullable', 'date_format:Y-m-d'],
            'student.notes' => ['nullable', 'string', 'max:10000'],
        ];

        if ($this->method() == 'POST') {
            if ($this->filled('guardian.id')) {
                $rules['guardian.id'] = ['required', 'exists:App\Models\User,id'];
            } else {
                /*$rules['guardian.email'] = [
                    'required', 'email',
                    Rule::unique('users')->whereNull('deleted_at')
                ];*/
                // $rules['guardian.password'] = ['required', 'confirmed'];
                // $rules['guardian.password_confirmation'] = ['required'];
                $rules['guardian.email'] = ['required', 'email'];
                $rules['guardian.name'] = ['required', 'string'];
                $rules['guardian.phone_number'] = ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'];
                $rules['guardian.address.zip_code'] = ['sometimes', 'nullable'];
                $rules['guardian.address.province'] = ['sometimes', 'nullable', 'string'];
                $rules['guardian.address.city']     = ['sometimes', 'nullable', 'string'];
                $rules['guardian.address.district'] = ['sometimes', 'nullable', 'string'];
                $rules['guardian.address.number']   = ['sometimes', 'nullable'];
                $rules['guardian.address.complement'] = ['sometimes', 'nullable', 'string'];
            }
        }

        if ($this->filled('student.email')) {
            $rules['student.email'] = ['unique:students,id', 'email'];
        }

        if ($this->filled('student.nickname')) {
            $rules['student.nickname'] = ['min:3', 'max:15'];
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
            'student.nickname.min' => 'O Apelido deve ter no mínimo 3 caracteres.',
            'student.nickname.max' => 'O Apelido deve ter no máximo 15 caracteres.',
            'student.grade_id.required' => 'O campo Série é obrigatório.',
            'student.domain_language_id.required' => 'O campo Idioma é obrigatório.',
            'student.domain_language_id.exists' => 'O campo Idioma deve ser válido.',
            'student.classrooms.required' => 'É necessário adicionar ao menos uma turma ao aluno.',
            'student.classrooms.exists' => 'As turmas adicionadas devem ser válidas.',
            'student.avatar' => 'Escolha um Avatar.',
            'student.avatar' => 'O Avatar deve ser válido.',
            'student.expires_at.date_format' => 'O campo de estar no formato d/m/Y.',
            'student.notes.max' => 'A Observação deve ter no máximo 255 caracteres.',
        ];

        if ($this->filled('guardian.id')) {
            $messages['guardian.id.exists'] = 'O Responsável deve ser válido.';
        } else {
            $messages['guardian.email.required'] = 'O campo E-mail é obrigatório.';
            $messages['guardian.email.unique'] = 'Este E-mail não está disponível.';
            $messages['guardian.password.required'] = 'O campo Senha é Obrigatório.';
            $messages['guardian.password.confirmed'] = 'A Confirmação da Senha não coincide.';
            $messages['guardian.password_confirmation.required'] = 'O campo Confirmação de Senha é obrigatório.';
            $messages['guardian.email.required'] = 'O campo E-Mail é Obrigatório.';
            $messages['guardian.email.unique'] = 'Este E-Mail já está em uso.';
            $messages['guardian.email.email'] = 'O E-Mail deve ser válido.';
            $messages['guardian.name.required'] = 'O campo Nome é obrigatório.';
            $messages['guardian.name.string'] = 'O Nome deve conter apenas letras.';
            $messages['guardian.phone_number.required'] = 'O campo Telefone é obrigatório.';
            $messages['guardian.phone_number.regex'] = 'O Telefone deve ser válido.';
            $messages['guardian.phone_number.min'] = 'O Telefone deve possuir no mínimo 10 caracteres.';
            $messages['guardian.address.zip_code.required']  = 'O campo Zip Code é obrigatório.';
            $messages['guardian.address.province.required']  = 'O campo Província é obrigatório.';
            $messages['guardian.address.province.string']  = 'O campo Província deve ser texto.';
            $messages['guardian.address.city.required']  = 'O campo Cidade é obrigatório.';
            $messages['guardian.address.city.string']  = 'O campo Cidade deve ser texto.';
            $messages['guardian.address.number.required']  = 'O campo Número é obrigatório.';
            $messages['guardian.address.district.required']  = 'O campo Bairro é obrigatório.';
            $messages['guardian.address.district.string']  = 'O campo Bairro deve ser texto.';
            $messages['guardian.address.complement.string']  = 'O campo Complemento deve ser texto.';
        }

        return $messages;
    }
}
