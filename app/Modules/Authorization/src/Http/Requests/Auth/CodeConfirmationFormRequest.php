<?php

namespace Authorization\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CodeConfirmationFormRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            "subject" => ["required"],
            "code" => ["required","numeric","regex:/^([0-9]*)$/"
               ,"digits:".config("code_verification.code_length")
                ]
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
