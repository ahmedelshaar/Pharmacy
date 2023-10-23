<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyRequest extends FormRequest
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
        $rules= [
            'name' => ['required','min:3'],
            'priority' => ['required'],
            'area_id' => ['required'],
//            'avatar' => ['required','image']
        ];
        if ($this->isMethod('POST')) {
            // 'avatar' is required when creating a new Pharmacy
            $rules['avatar'] = ['required', 'image'];
        } else {
            // 'avatar' is not required when updating an existing Pharmacy
            $rules['avatar'] = ['nullable', 'image'];
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'priority.required' => 'Priority is required',
            'area_id.required' => 'Area is required',
            'avatar.required' => 'Avatar is required',
            'avatar.image' => 'Avatar must be in image format',
            'name.min' => 'Name must be at least 3 letters'
    ];
    }
}
