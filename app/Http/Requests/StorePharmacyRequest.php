<?php

namespace App\Http\Requests;
use App\Http\Models\Area;

use Illuminate\Foundation\Http\FormRequest;

class StorePharmacyRequest extends FormRequest
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
            //
            'name' => 'required|min:5',
            'priority'=>'required',
            'area_id' => 'required|exists:App\Models\Area,id',
            'avatar' => 'required|image|mimes:jpeg,jpg|max:2048',
        ];
    }

    public function message(): array
    {
        return [
            //
            'name.required' => 'Title is required',
            'name.min' => 'Title must be at least 3 characters',
            'description.required' => 'description is required',
            'description.min' => 'description must be at least 10 characters',
            'area_id.required' => 'Area is required',
            'area_id.exists' => 'Area does not exist',
        ];
    }
}