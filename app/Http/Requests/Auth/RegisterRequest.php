<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:50',
            'email'=>   'required|email|unique:users,email',
            'gender'=>  'required|in:male,female,other',
            'password'=> 'required|min:8|max:50',
            'confirmedPassword'=> 'required|same:password',
            'birth_date'=> 'required|date',
            'phone' => ['required','regex:/^01[0-2|5]{1}[0-9]{8}$/','unique:users,phone'],
            'national_id' => ['required','unique:users,national_id','regex:/^\d{14}$/'],
            'image'=> 'required|image',

        ];
    }
    public function messages()
    {
        return [
            'name.required'=> 'name is required',
            'name.string'=> 'name must be a string',
            'name.min'=> 'Your name must be at least :min characters',
            'name.max'=> 'Your name must be at max :max characters',
            'email.required' => 'email is required',
            'email.email' => 'invalid email format',
            'email.unique' => 'email already exist',
            'gender.required' => 'gender is required',
            'gender.in' => 'Please select either "male" or "female" or "other" for your gender.',
            'password.required' => 'password is required',
            'password.min' => 'password must be at least :min characters',
            'password.max' => 'password must be at max :max characters',
            'confirmedPassword.required' => 'confirmed password is required',
            'confirmedPassword.same' => 'confirmed password not match password',
            'birth_date.required' => 'date of birth is required',
            'birth_date.date' => 'invalid format  date of birth',
            'phone.required' => 'mobile number is required',
            'phone.regex' => 'invalid mobile number format',
            'phone.unique' => 'this mobile number is already exists',
            'national_id.required' => 'national Identity is required',
            'national_id.regex' => 'invalid national identity format',
            'national_id.unique' => 'this national identity already exists',
            'image.required' => 'profile image is required',
            'image.image' => 'invalid image extension format'
        ];
    }
}
