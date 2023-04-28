<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressStoreRequest extends FormRequest
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
            'area_id' => 'required|exists:areas,id',
            'street_name' => 'required|string|min:3|max:255',
            'building_number' => 'required|numeric:min:1',
            'floor_number' => 'required|numeric:min:1',
            'flat_number' => 'required|numeric:min:1',
            'is_main' => 'required|boolean',
        ];
    }
}
