<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')],
            'parent_id' => ['sometimes', 'nullable', 'integer', Rule::exists('categories', 'id')],
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
            'name.required' => 'The category name is required.',
            'name.string' => 'The category name must be a string.',
            'name.max' => 'The category name may not be greater than 255 characters.',
            'slug.required' => 'The category slug is required.',
            'slug.string' => 'The category slug must be a string.',
            'slug.max' => 'The category slug may not be greater than 255 characters.',
            'slug.unique' => 'The category slug has already been taken.',
            'parent_id.integer' => 'The parent_id must be an integer.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'is_active.boolean' => 'The is_active field must be true or false.',
        ];
    }
}
