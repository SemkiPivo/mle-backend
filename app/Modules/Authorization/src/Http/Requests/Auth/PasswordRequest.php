<?php

namespace Authorization\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PasswordRequest extends FormRequest
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
            "phone" => ["required","numeric","regex:/^([0-9\s\-\+\(\)]*)$/","digits_between:8,12"],
            "code" => ["required","numeric","regex:/^([0-9]*)$/","digits:".config("code_verification.code_length")],
            "password" => ["required","string","min:6","max:255","required_with:password_confirmation"],
            'password_confirmation' => ['required_with:password',"string",'same:password','min:6']
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
