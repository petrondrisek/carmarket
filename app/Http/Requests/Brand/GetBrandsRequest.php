<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class GetBrandsRequest extends FormRequest
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
            'per_page' => ['nullable', 'integer', 'min:1'],
            'page' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string', 'max:255'],
            'only_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array {
        return [
            'per_page.integer' => 'Per Page must be an integer',
            'per_page.min' => 'Per Page must be at least 1',
            'page.integer' => 'Page must be an integer',
            'page.min' => 'Page must be at least 1',
            'search.string' => 'Search must be a string',
            'search.max' => 'Search must be less than 255 characters',
            'only_active.boolean' => 'Only Active must be a boolean',
        ];
    }
}
