<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "role" => "required|min:3|max:120|regex:/^[^<>]*$/",
            "description" => "required|min:3|max:120|regex:/^[^<>]*$/",
        ];

        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules["role"] = [
                "nullable",
            ];
            $rules["description"] = [
                'nullable',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "role.required" => "O cargo é obrigatório.",
            "role.min" => "O cargo deve ter pelo menos 3 caracteres.",
            "role.max" => "O cargo não pode ter mais de 120 caracteres.",
            "role.regex" => "O cargo contém caracteres inválidos.",

            "description.required" => "A descrição é obrigatório.",
            "description.min" => "A descrição deve ter pelo menos 3 caracteres.",
            "description.max" => "A descrição não pode ter mais de 120 caracteres.",
            "description.regex" => "A descrição contém caracteres inválidos.",

        ];
    }
}
