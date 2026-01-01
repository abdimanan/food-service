<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductVariantPriceRequest extends FormRequest
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
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'variant_option_id' => ['required', 'integer', Rule::exists('variant_options', 'id')],
            'price' => ['required', 'decimal:0,2', 'min:0'],
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
            'product_id.required' => 'The product ID is required.',
            'product_id.integer' => 'The product ID must be an integer.',
            'product_id.exists' => 'The selected product does not exist.',
            'variant_option_id.required' => 'The variant option ID is required.',
            'variant_option_id.integer' => 'The variant option ID must be an integer.',
            'variant_option_id.exists' => 'The selected variant option does not exist.',
            'price.required' => 'The price is required.',
            'price.decimal' => 'The price must be a valid decimal number.',
            'price.min' => 'The price must be at least 0.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
