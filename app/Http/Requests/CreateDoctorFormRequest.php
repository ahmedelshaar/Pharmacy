<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /*
    public function authorize(): bool
    {
        return false;
    }
    */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|alpha|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email',
            //'password' => 'required|string|min:6|confirmed',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|max:2048',
            'national_id' => 'required|numeric|unique:doctors,national_id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name field can not be less than :min characters.',
            'name.max' => 'The name field can not be greater than :max characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email field must be a valid email address.',
            'email.max' => 'The email field can not be greater than :max characters.',
            'email.unique' => 'The email address is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password field must be at least :min characters.',
            //'password.confirmed' => 'The password confirmation does not match.',
            'image.image' => 'The image must be an image file.',
            'image.max' => 'The image can not be greater than :max kilobytes.',
            'national_id.required' => 'The national ID field is required.',
            'national_id.unique' => 'The national ID is already taken.',
            'pharmacy_id.required' => 'The pharmacy field is required.',
            'pharmacy_id.exists' => 'The selected pharmacy is invalid.',
        ];
    }
}
