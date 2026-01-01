<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVariantOptionRequest extends FormRequest
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
            'variant_id' => ['required', 'integer', Rule::exists('variants', 'id')],
            'name' => ['required', 'string', 'max:255'],
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
            'variant_id.required' => 'The variant ID is required.',
            'variant_id.integer' => 'The variant ID must be an integer.',
            'variant_id.exists' => 'The selected variant does not exist.',
            'name.required' => 'The variant option name is required.',
            'name.string' => 'The variant option name must be a string.',
            'name.max' => 'The variant option name may not be greater than 255 characters.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
