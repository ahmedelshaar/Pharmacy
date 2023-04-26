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
            'email' => 'exclude',
            'password' => 'nullable|string|min:6|confirmed',
            'national_id' => 'sometimes|numeric|unique:users,national_id,' . $this->user->id,
            'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'image' => 'sometimes|image|mimes:png,jpg|max:4048',
            'gender' => 'sometimes|in:Male,Female,Other',
            'birth_date' => 'sometimes|date',
        ];
    }


    public function messages(): array
    {
        return [
            'name.string' => __('validation.string', ['attribute' => 'name']), //??
        ];
    }
}
