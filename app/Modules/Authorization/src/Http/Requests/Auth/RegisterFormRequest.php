<?php

namespace Authorization\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterFormRequest extends FormRequest
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
//        $request['phone'] = preg_phone($request['phone']);
        return [
            'name' => ['required','max:255','min:1','string'],
            'email' => ['required','email','unique:users','max:255','min:3','string'],
            'phone' => ['required','unique:users','min:3','max:20','string'],
            'password' => ['required','confirmed','max:255','min:6'],
            'birthday' => ['required','date'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'is_notifiable' => ['required','boolean'],
            'location_id' => ['nullable' ,Rule::exists('locations', 'id')],
//            'location_id' => ['required',Rule::exists('locations', 'id')],
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
