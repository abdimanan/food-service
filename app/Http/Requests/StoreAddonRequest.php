<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddonRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'base_price' => ['required', 'decimal:0,2', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The addon name is required.',
            'name.string' => 'The addon name must be a string.',
            'name.max' => 'The addon name may not be greater than 255 characters.',
            'base_price.required' => 'The base price is required.',
            'base_price.decimal' => 'The base price must be a valid decimal number.',
            'base_price.min' => 'The base price must be at least 0.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
