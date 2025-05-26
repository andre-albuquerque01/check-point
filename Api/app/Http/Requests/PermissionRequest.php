<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'permission' => 'required|in:admin,editor,viewer',
        ];

        $rules["permission"] = [
            'nullable',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'permission.required' => 'É necessário selecionar pelo menos uma permissão.',
            'permission.in' => 'A permissão selecionada é inválida. As opções válidas são: admin, editor ou viewer.',
        ];
    }
}
