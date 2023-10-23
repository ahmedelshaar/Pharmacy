<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'is_insured' => 'boolean',
            'prescription.*' => 'image|max:2048',
            'delivering_address_id' => [
                'exists:user_addresses,id,user_id,' . Auth::id(),
            ],

        ];
    }
        public function messages(){
        return [
            'Is_insured.boolean' => 'Is_insured must be true or false',
            'prescription.*.image' => 'The file must be an image',
            'prescription.*.max' => 'The file may not be greater than :max kilobytes',
            'delivering_address_id.exists' => 'this address not belongs to this user',
        ];
    }
}
