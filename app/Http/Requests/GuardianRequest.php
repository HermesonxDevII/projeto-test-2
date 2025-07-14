<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

class GuardianRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->status;
    }

    public function rules()
    {
        $guardian_id = $this->id ? $this->id : null;

        // return dd($this->request);

        $rules = [
            'name' => ['string', 'required', 'min:5'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                ->ignore($guardian_id, 'id')
                ->whereNull('deleted_at'),
            ],
            'phone_number' => ['required', 'min:8'],
            'address.zip_code' => ['sometimes','nullable', 'max:255'],
            'address.province' => ['sometimes','nullable', 'max:255'],
            'address.city' => ['sometimes','nullable', 'max:255'],
            'address.district' => ['sometimes','nullable', 'max:255'],
            'address.number' => ['sometimes','nullable'],
            'address.complement' => ['max:255']
        ];

        if ($this->method() == 'POST')
        {
            // $rules['password'] = ['required', 'confirmed', 'min:8'];
            // $rules['password_confirmation'] = ['required'];
        }
        else if ($this->method('PUT'))
        {
            $rules['profile_photo'] = ['nullable'];

            if ($this->filled('password'))
            {
                $rules['password'] = ['required', 'confirmed', 'min:8'];
                $rules['password_confirmation'] = ['required'];
            } else
            {
                $rules['password'] = ['nullable'];
                $rules['password.confirmed'] = ['nullable'];
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.string' => 'O campo Nome não é válido.',
            'name.required' => 'O campo Nome é obrigatório.',
            'name.min' => 'O campo Nome deve conter no mínimo 5 caracteres.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'password.required' => 'A Senha é obrigatória.',
            'password.confirmed' => 'A Confirmação Senha não coincide.',
            'password_confirmation.required' => 'A confirmação da senha é obrigatória.',
            'password.min' => 'O campo de senha deve conter no mínimo 8 caracteres.',
            'email.email' => 'O campo E-mail deve ser válido.',
            'email.unique' => 'Este E-mail não está disponível.',
            'phone_number.required' => 'O campo Telefone é obrigatório.',
            'address.zip_code.required' => 'O campo Zip Code é obrigatório.',
            'address.zip_code.max' => 'O campo Zip Code deve conter no máximo 255 caracteres.',
            'address.province.required' => 'O campo Província é obrigatório.',
            'address.province.max' => 'O campo Província deve conter no máximo 255 caracteres.',
            'address.city.required' => 'O campo Cidade é obrigatório.',
            'address.city.max' => 'O campo Cidade deve conter no máximo 255 caracteres.',
            'address.district.required' => 'O campo Bairro é obrigatório.',
            'address.district.max' => 'O campo Bairro deve conter no máximo 255 caracteres.',
            'address.number.required' => 'O campo Número é obrigatório.',
            'address.complement.max' => 'O campo Complemento deve conter no máximo 255 caracteres.'
        ];

        $messages['password.confirmed'] = 'A Confirmação da Senha não coincide.';
        $messages['password_confirmation.required'] = 'O campo Confirmação de Senha é obrigatório.';

        return $messages;
    }
}
