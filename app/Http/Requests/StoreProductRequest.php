<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'vendor_id' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'decimal:0,2', 'min:0'],
            'is_live' => ['sometimes', 'boolean'],
            'preparation_time' => ['nullable', 'integer', 'min:0'],
            'min_order_quantity' => ['sometimes', 'integer', 'min:1'],
            'variants' => ['sometimes', 'array'],
            'variants.*.name' => ['required_with:variants', 'string', 'max:255'],
            'variants.*.price' => ['required_with:variants', 'decimal:0,2', 'min:0'],
            'variants.*.is_default' => ['sometimes', 'boolean'],
            'addons' => ['sometimes', 'array'],
            'addons.*.name' => ['required_with:addons', 'string', 'max:255'],
            'addons.*.price' => ['required_with:addons', 'decimal:0,2', 'min:0'],
            'addons.*.is_required' => ['sometimes', 'boolean'],
            'media' => ['sometimes', 'array'],
            'media.*.file_url' => ['required_with:media', 'url', 'max:2048'],
            'media.*.type' => ['required_with:media', Rule::in(['image', 'video'])],
            'media.*.position' => ['sometimes', 'integer', 'min:0'],
            'tags' => ['sometimes', 'array'],
            'tags.*.tag' => ['required_with:tags', 'string', 'max:255'],
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
            'vendor_id.required' => 'The vendor ID is required.',
            'vendor_id.integer' => 'The vendor ID must be an integer.',
            'vendor_id.min' => 'The vendor ID must be at least 1.',
            'category_id.required' => 'The category ID is required.',
            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category does not exist.',
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'slug.required' => 'The product slug is required.',
            'slug.string' => 'The product slug must be a string.',
            'slug.max' => 'The product slug may not be greater than 255 characters.',
            'slug.unique' => 'The product slug has already been taken.',
            'description.string' => 'The description must be a string.',
            'price.required' => 'The price is required.',
            'price.decimal' => 'The price must be a valid decimal number.',
            'price.min' => 'The price must be at least 0.',
            'is_live.boolean' => 'The is_live field must be true or false.',
            'preparation_time.integer' => 'The preparation time must be an integer.',
            'preparation_time.min' => 'The preparation time must be at least 0.',
            'min_order_quantity.integer' => 'The minimum order quantity must be an integer.',
            'min_order_quantity.min' => 'The minimum order quantity must be at least 1.',
            'variants.array' => 'The variants must be an array.',
            'variants.*.name.required_with' => 'Each variant must have a name.',
            'variants.*.name.string' => 'Each variant name must be a string.',
            'variants.*.name.max' => 'Each variant name may not be greater than 255 characters.',
            'variants.*.price.required_with' => 'Each variant must have a price.',
            'variants.*.price.decimal' => 'Each variant price must be a valid decimal number.',
            'variants.*.price.min' => 'Each variant price must be at least 0.',
            'variants.*.is_default.boolean' => 'Each variant is_default field must be true or false.',
            'addons.array' => 'The addons must be an array.',
            'addons.*.name.required_with' => 'Each addon must have a name.',
            'addons.*.name.string' => 'Each addon name must be a string.',
            'addons.*.name.max' => 'Each addon name may not be greater than 255 characters.',
            'addons.*.price.required_with' => 'Each addon must have a price.',
            'addons.*.price.decimal' => 'Each addon price must be a valid decimal number.',
            'addons.*.price.min' => 'Each addon price must be at least 0.',
            'addons.*.is_required.boolean' => 'Each addon is_required field must be true or false.',
            'media.array' => 'The media must be an array.',
            'media.*.file_url.required_with' => 'Each media item must have a file URL.',
            'media.*.file_url.url' => 'Each media file URL must be a valid URL.',
            'media.*.file_url.max' => 'Each media file URL may not be greater than 2048 characters.',
            'media.*.type.required_with' => 'Each media item must have a type.',
            'media.*.type.in' => 'Each media type must be either image or video.',
            'media.*.position.integer' => 'Each media position must be an integer.',
            'media.*.position.min' => 'Each media position must be at least 0.',
            'tags.array' => 'The tags must be an array.',
            'tags.*.tag.required_with' => 'Each tag must have a value.',
            'tags.*.tag.string' => 'Each tag must be a string.',
            'tags.*.tag.max' => 'Each tag may not be greater than 255 characters.',
        ];
    }
}
