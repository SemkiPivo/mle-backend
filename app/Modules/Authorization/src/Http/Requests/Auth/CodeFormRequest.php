<?php

namespace Authorization\Http\Requests\Auth;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CodeFormRequest extends FormRequest
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
        if ($request->get("rule") === "exist"){
            return [
                "subject" => ["required","exists:users"]
            ];
        }
        if ($request->get("rule") === "dont_exist"){
            return [
                "subject" => ["required","unique:users"]
            ];
        }
        if (!$request->get("rule")){
            return [
                "subject" => ["required"]
            ];
        }

    }

    public function messages()
    {
        return [

        ];
    }
}
