<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachProductTagsRequest extends FormRequest
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
            'tags' => ['required', 'array'],
            'tags.*' => ['required', 'integer', Rule::exists('tags', 'id')],
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
            'tags.required' => 'The tags field is required.',
            'tags.array' => 'The tags must be an array.',
            'tags.*.required' => 'Each tag ID is required.',
            'tags.*.integer' => 'Each tag ID must be an integer.',
            'tags.*.exists' => 'One or more selected tags do not exist.',
        ];
    }
}
