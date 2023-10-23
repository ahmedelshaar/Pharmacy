<?php

namespace App\Http\Requests\UserAddress\Api;

use Illuminate\Foundation\Http\FormRequest;

class EditUserAddressRequest extends FormRequest
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
            'street_name' => 'string|max:255',
            'building_number' => 'numeric|min:1',
            'floor_number' => 'numeric|min:0',
            'flat_number' => 'numeric|min:1',
            'is_main' => 'nullable|boolean',
            'user_id' => 'exists:users,id',
            'area_id' => 'exists:areas,id',
        ];
    }

    public function messages()
    {
        return [
            'building_number.min' => 'building number must be at least 1.',
            'floor_number.min' => 'Floor number must be at least 0.',
            'flat_number.min' => 'Falt number must be at least 1.',
            'user_id.exists' => 'user ID is invalid.',
            'area_id.exists' => 'area ID is invalid.',
        ];
    }
}
