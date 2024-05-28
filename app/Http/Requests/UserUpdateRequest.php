<?php

namespace App\Http\Requests;

use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => ['max:255','min:1','string'],
            'email' => ['email','unique:users','max:255','min:3','string'],
            'phone' => ['unique:users','min:3','max:14','string'],
            'password' => ['confirmed','max:255','min:6'],
            'birthday' => ['date'],
            'gender' => [Rule::in(['male', 'female'])],
            'about' => ['nullable','string'],
            'is_notifiable' => ['boolean'],
            'location_id' => [Rule::exists('locations', 'id')],
        ];
    }
}
