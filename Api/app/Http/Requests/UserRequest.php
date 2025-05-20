<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "name" => "required|min:3|max:120|regex:/^[^<>]*$/",
            "role_id" => "required|min:3",
            "email" => [
                "required",
                "email",
                "max:255",
                "min:2",
                "unique:users",
            ],
            "password" => [
                "required",
                "confirmed",
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            "password_confirmation" => [
                "required",
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ];

        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules["name"] = [
                "nullable",
                "min:3",
                "max:120",
            ];
            $rules["email"] = [
                "nullable",
                "email",
                "max:255",
                Rule::unique('users', 'email')->ignore($this->user()->id, 'id'),
            ];
            $rules["password"] = [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ];
            $rules["password_confirmation"] = [
                'nullable',
            ];
            $rules["role_id"] = [
                'nullable',
            ];
            $rules["permissions"] = [
                'nullable',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "name.required" => "O nome é obrigatório.",
            "name.min" => "O nome deve ter pelo menos 3 caracteres.",
            "name.max" => "O nome não pode ter mais de 120 caracteres.",
            "name.regex" => "O nome contém caracteres inválidos.",

            "role_id.required" => "O cargo é obrigatório.",

            "email.required" => "O e-mail é obrigatório.",
            "email.email" => "O e-mail informado não é válido.",
            "email.max" => "O e-mail não pode ter mais de 255 caracteres.",
            "email.min" => "O e-mail deve ter pelo menos 2 caracteres.",
            "email.unique" => "Este e-mail já está cadastrado.",

            "password.required" => "A senha é obrigatória.",
            "password.confirmed" => "A confirmação da senha não corresponde.",
            "password.min" => "A senha deve ter pelo menos 8 caracteres.",
            "password.mixedCase" => "A senha deve conter pelo menos uma letra maiúscula e uma minúscula.",
            "password.letters" => "A senha deve conter pelo menos uma letra.",
            "password.numbers" => "A senha deve conter pelo menos um número.",
            "password.symbols" => "A senha deve conter pelo menos um símbolo.",
            "password.uncompromised" => "A senha escolhida já apareceu em vazamentos de dados. Escolha outra senha.",

            "password_confirmation.required" => "A confirmação da senha é obrigatória.",
            "password_confirmation.min" => "A confirmação da senha deve ter pelo menos 8 caracteres.",

            'permission.required' => 'É necessário selecionar pelo menos uma permissão.',
            'permission.array' => 'O formato das permissões selecionadas está inválido.',
            'permission.*.exists' => 'Uma ou mais permissões selecionadas são inválidas.',
        ];
    }
}
