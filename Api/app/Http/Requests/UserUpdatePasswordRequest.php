<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdatePasswordRequest extends FormRequest
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
            "password_old" => [
                "required",
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
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
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            "password.required" => "A senha é obrigatória.",
            "password.confirmed" => "A confirmação da senha não corresponde.",
            "password.min" => "A senha deve ter pelo menos 8 caracteres.",
            "password.mixedCase" => "A senha deve conter pelo menos uma letra maiúscula e uma minúscula.",
            "password.letters" => "A senha deve conter pelo menos uma letra.",
            "password.numbers" => "A senha deve conter pelo menos um número.",
            "password.symbols" => "A senha deve conter pelo menos um símbolo.",
            "password.uncompromised" => "A senha escolhida já apareceu em vazamentos de dados. Escolha outra senha.",

            "password_new.required" => "A nova senha é obrigatória.",
            "password_new.confirmed" => "A confirmação da nova senha não corresponde.",
            "password_new.min" => "A nova senha deve ter pelo menos 8 caracteres.",
            "password_new.mixedCase" => "A nova senha deve conter pelo menos uma letra maiúscula e uma minúscula.",
            "password_new.letters" => "A nova senha deve conter pelo menos uma letra.",
            "password_new.numbers" => "A nova senha deve conter pelo menos um número.",
            "password_new.symbols" => "A nova senha deve conter pelo menos um símbolo.",
            "password_new.uncompromised" => "A nova senha escolhida já apareceu em vazamentos de dados. Escolha outra senha.",


            "password_confirmation.required" => "A confirmação da senha é obrigatória.",
            "password_confirmation.min" => "A confirmação da senha deve ter pelo menos 8 caracteres.",
        ];
    }
}
