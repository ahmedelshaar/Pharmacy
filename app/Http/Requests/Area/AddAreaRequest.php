<?php

namespace App\Http\Requests\Area;

use Illuminate\Foundation\Http\FormRequest;

class AddAreaRequest extends FormRequest
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
            'name' => 'required|string',
            'country_id' => 'required|integer|exists:countries,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Area Name is Required',
            'name.string' => 'Area Name Must be Characters',
            'country_id.required' => 'You Must Choose Country',
            'country_id.integer' => 'Country ID mu be Number',
            'country_id.exists' => "Invalid County"
        ];
    }
}
