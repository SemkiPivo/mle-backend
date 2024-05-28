<?php

namespace App\Http\Requests;

use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return true;
//    }

    public function rules(): array
    {
        return [
            'name' => ['required','max:255','min:1','string'],
            'email' => ['required','email','unique:users','max:255','min:3','string'],
            'phone' => ['required','unique:users','min:3','max:14','string'],
            'password' => ['required','confirmed','max:255','min:6'],
            'birthday' => ['required','date'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'about' => ['nullable','string'],
            'is_notifiable' => ['required','boolean'],
            'location_id' => ['required',Rule::exists('locations', 'id')],
        ];
    }
}
