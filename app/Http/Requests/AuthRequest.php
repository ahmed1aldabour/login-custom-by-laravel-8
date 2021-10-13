<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
    }
    public function messages()
    {
        return[
            'name.required'         =>__('register.name.required'),
            'email.required'        =>__('register.email.required'),
            'email.email'           =>__('register.email.email'),
            'email.unique'          =>__('register.name.string'),
            'password.required'     =>__('register.password.required'),
            'password.min'          =>__('register.name.string'),
            'password.confirmed'    =>__('register.name.string'),
        ];
    }
}
