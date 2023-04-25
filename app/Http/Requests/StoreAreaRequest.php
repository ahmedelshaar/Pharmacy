<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
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
          
                'name' => ['required', 'unique:areas','min:5'],
                'country_id' => ['required', 'min:1'] 
        ];

    }
    
    public function messages(){
            
        return[
            'name.required'=>'my custom message',
            'country_id.min'=>'my custom message for min rule',
        ];
        }
}
