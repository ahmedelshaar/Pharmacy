<?php

namespace App\Http\Requests\API;

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
            'is_insured' => 'required|boolean',
            'prescription' => 'required|array|min:1',
            'prescription.*' => 'required|image',
            'address_id' => 'required|exists:user_addresses,id,user_id,' . auth()->id(),
        ];
    }
}
