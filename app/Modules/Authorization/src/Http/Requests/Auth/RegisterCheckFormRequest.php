<?php

namespace Authorization\Http\Requests\Auth;

//use App\Http\Requests\FormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RegisterCheckFormRequest extends FormRequest
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
            "phone" => ["required","unique:users","numeric","regex:/^([0-9\s\-\+\(\)]*)$/","digits_between:8,12"],
            "email" => ["nullable","unique:users","email"],
            "first_name" => ["required","string","min:3","max:255"],
            "last_name" => ["required","string","min:3","max:255"],
            "middle_name" => ["nullable","string","min:3","max:255"],
            "birthday" => ["required","date","date_format:Y-m-d"],
            "code" => ["required","numeric","regex:/^([0-9]*)$/","digits:".config("code_verification.code_length")]
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
