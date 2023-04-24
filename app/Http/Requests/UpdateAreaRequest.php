<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
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
              //Validate Area Updated Data to be optional
              'name' => 'sometimes|string|max:255',
              'country_id' => 'sometimes|numeric|min:1',
              
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.string' => __('validation.string', ['attribute' => 'name']),
        ];
    }
}
