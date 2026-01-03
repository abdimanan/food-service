<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'vendor_id' => ['sometimes', 'integer', 'min:1'],
            'category_id' => ['sometimes', 'integer', Rule::exists('categories', 'id')],
            'name' => ['sometimes', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'decimal:0,2', 'min:0'],
            'is_live' => ['sometimes', 'boolean'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
            'min_order_quantity' => ['sometimes', 'integer', 'min:1'],
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
            'vendor_id.integer' => 'The vendor ID must be an integer.',
            'vendor_id.min' => 'The vendor ID must be at least 1.',
            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'slug.string' => 'The product slug must be a string.',
            'slug.max' => 'The product slug may not be greater than 255 characters.',
            'slug.unique' => 'The product slug has already been taken.',
            'description.string' => 'The description must be a string.',
            'price.decimal' => 'The price must be a valid decimal number.',
            'price.min' => 'The price must be at least 0.',
            'is_live.boolean' => 'The is_live field must be true or false.',
            'preparation_time.integer' => 'The preparation time must be an integer.',
            'preparation_time.min' => 'The preparation time must be at least 0.',
            'min_order_quantity.integer' => 'The minimum order quantity must be an integer.',
            'min_order_quantity.min' => 'The minimum order quantity must be at least 1.',
        ];
    }
}
