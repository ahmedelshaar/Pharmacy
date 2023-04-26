<?php

namespace App\Http\Requests;
use App\Http\Models\Area;

use App\Rules\NameValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PharmacyStoreRequest extends FormRequest
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
            'name' => ['required','min:5', new NameValidationRule],
            'priority'=>'required',
            'area_id' => 'required|exists:areas,id',
            'avatar' => 'required|image|max:2048',
            'doctor_name' => ['required','min:2','max:255', new NameValidationRule],
            'email' => 'required|string|email|max:255|unique:doctors,email',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'national_id' => 'required|numeric|unique:doctors,national_id',
        ];
    }

    public function message(): array
    {
        return [
        ];
    }
}
