<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaStoreRequest extends FormRequest
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
            'name' => ['required', 'unique:areas','min:3'],
            'country_id' => ['required', 'exists:countries,id'],
        ];

    }

    public function messages(){
        return[
        ];
    }
}
