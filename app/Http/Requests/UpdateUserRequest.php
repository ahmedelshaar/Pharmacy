<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //Validate User Updated Data to be optional
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'password' => 'sometimes|string|min:6',
            'national_id' => 'sometimes|numeric|unique:users',
            'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'image' => 'sometimes|image|mimes:png,jpg|max:4048',
            'gender' => 'sometimes',
            'birth_date' => 'sometimes|date',
        ];
    }


    public function messages(): array{
        return [
            //Custom Error Messages
//            'name.required' => 'Name is required',
//            'email.required' => 'Email is required',
//            'password.required' => 'Password is required',
//            'national_id.required' => 'National ID is required',
//            'phone.required' => 'Phone is required',

            'name.string' => 'Name must be string',
            'email.string' => 'Email must be string',
            'password.string' => 'Password must be string',
            'national_id.numeric' =>'National ID must be numeric',
            'phone.regex' => 'Phone must be numeric',

            'name.max' => 'Name must be less than 255 characters',
            'email.max' => 'Email must be less than 255 characters',
            'password.min' => 'Password must be at least 6 characters',
            'phone.min' => 'Phone must be at least 10 characters',

            'email.email' => 'Email must be valid email',
            'password.confirmed' => 'Password must be confirmed',
//            'password.password' => 'Password must be strong password
//             having at least one uppercase letter, one lowercase letter, one digit and one special character',

            'email.unique' => 'Email must be unique',
            'national_id.unique' => 'National ID must be unique',

//            'image.required' => 'Image is required',
            'image.mimes' => 'Image must be png,jpg',
            'image.max' => 'Image size maximum 4mb',

//            'birth_date.required' => 'Birth Date is required',
            'birth_date.date' => 'Birth Date must be date',

//            gender Messages
//            'gender.required' => 'Gender Is Required',
            'gender.in' => 'The gender field must be one of: male, female, other.',
        ];
    }
}
