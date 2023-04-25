<?php

namespace App\Http\Requests;

use App\Rules\NameValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
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
            'name' => ['required','min:2','max:255', new NameValidationRule],
            'email' => 'required|string|email|max:255|unique:doctors,email,' . $this->doctor->id,
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'national_id' => 'required|numeric|unique:doctors,national_id,' . $this->doctor->id,
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'is_banned' => 'nullable|in:1',
        ];
    }
}
