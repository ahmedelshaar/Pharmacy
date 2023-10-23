<?php

namespace App\Http\Requests\UserAddress;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddUserAddressRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'street_name' => 'required|string|max:255',
            'building_number' => 'required|numeric|min:1',
            'floor_number' => 'required|numeric|min:0',
            'flat_number' => 'required|numeric|min:1',
            'is_main' => 'nullable|boolean',
            'area_id' => 'required|exists:areas,id',
        ];
    }

    public function messages()
    {
        return [
            'street_name.required' => 'street name field is required.',
            'building_number.required' => 'building number field is required.',
            'building_number.min' => 'building number must be at least 1.',
            'floor_number.required' => 'Floor number field is required.',
            'floor_number.min' => 'Floor number must be at least 0.',
            'flat_number.required' => 'Flat number field is required.',
            'flat_number.min' => 'Falt number must be at least 1.',
            'area_id.required' => 'area ID field is required.',
            'area_id.exists' => 'area ID is invalid.',
        ];
    }
}
