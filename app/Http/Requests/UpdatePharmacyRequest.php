<?php

namespace App\Http\Requests;
use App\Http\Models\Area;


use App\Rules\NameValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePharmacyRequest extends FormRequest
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
            'name' => ['required','min:5', new NameValidationRule],
            'priority'=>'required|in:1,2,3,4,5',
            'area_id' => 'required|exists:App\Models\Area,id',
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
