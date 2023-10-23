<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8|max:50',
        ];
    }
    public  function messages()
    {
        return [
            'email.required' => 'email is required',
            'email.email' => 'invalid email format',
            'password.required' => 'password is required',
            'password.min' => 'password must be at least :min characters',
            'password.max' => 'password must be at max :max characters',
        ];
    }
}
