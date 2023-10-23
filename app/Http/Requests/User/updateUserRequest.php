<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
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
            'name' => 'string|min:3|max:50',
            'gender' => 'in:male,female,other',
            'birth_date' => 'date|before_or_equal:today',
            'phone' => ['regex:/^01[0-2|5]{1}[0-9]{8}$/','unique:users,phone'],
            'national_id' =>['unique:users,national_id','regex:/^\d{14}$/'],
            'image' =>'image'

        ];
    }
    public function messages()
    {
        return [
            'name.string'=> 'name must be a string',
            'name.min'=> 'Your name must be at least :min characters',
            'name.max'=> 'Your name must be at max :max characters',
            'gender.in' => 'Please select either "male" or "female" or "other" for your gender.',
            'birth_date.date' => 'invalid format  date of birth',
            'birth_date.before_or_equal' => 'invalid  date of birth',
            'phone.regex' => 'invalid mobile number format',
            'phone.unique' => 'this mobile number is already exists',
            'national_id.regex' => 'invalid national identity format',
            'national_id.unique' => 'this national identity already exists',
            'image.image' => 'invalid image extension format'
        ];
    }
}
