<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'is_insured' => 'boolean',
            'prescription' => 'required|array',
            'pharmacy_id' => 'nullable|exists:pharmacies,id',
            'address_id' => 'required|exists:user_addresses,id,user_id,' . $this->user_id,
            'user_id' => 'nullable|exists:users,id',
            'doctor_id' => 'nullable|exists:users,id',
        ];
    }
}
