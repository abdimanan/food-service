<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductAddonRequest extends FormRequest
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
            'product_id' => ['sometimes', 'integer', Rule::exists('products', 'id')],
            'addon_id' => ['sometimes', 'integer', Rule::exists('addons', 'id')],
            'price_override' => ['nullable', 'decimal:0,2', 'min:0'],
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
            'product_id.integer' => 'The product ID must be an integer.',
            'product_id.exists' => 'The selected product does not exist.',
            'addon_id.integer' => 'The addon ID must be an integer.',
            'addon_id.exists' => 'The selected addon does not exist.',
            'price_override.decimal' => 'The price override must be a valid decimal number.',
            'price_override.min' => 'The price override must be at least 0.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
