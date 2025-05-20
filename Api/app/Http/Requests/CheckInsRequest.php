<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInsRequest extends FormRequest
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
            "check_in_time" => "required|date_format:H:i:s",
            "check_out_time" => "required|date_format:H:i:s|after_or_equal:check_in_time",
            "check_date" => "required|date",
            "user_id" => "nullable|min:3",
        ];

        if ($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules["check_in_time"] = [
                "nullable",
            ];
            $rules["check_out_time"] = [
                'nullable',
            ];
            $rules["check_date"] = [
                'nullable',
            ];
            $rules["user_id"] = [
                'nullable',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "check_in_time.required" => "A data de inicio do checking é obrigatório.",
            "check_in_time.date" => "A data de inicio do checking informado não é válido.",

            "check_out_time.required" => "A data de finilização do checking é obrigatório.",
            "check_out_time.date" => "A data de finilização do checking informado não é válido.",
            "check_out_time.after_or_equal" => "A data de finilização do checking deve ser igual ou maior que de inicio.",

            "check_date.required" => "A data de checking é obrigatório.",
            "check_date.date" => "A data de checking informado não é válido.",
        ];
    }
}
