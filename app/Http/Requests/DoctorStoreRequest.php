<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
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
            'name' => 'required|alpha|min:2|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'national_id' => 'required|numeric|unique:doctors,national_id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
        ];
    }
    public function messages()
    {
        return [];
    }
}
