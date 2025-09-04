<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterBrandRequest extends FormRequest
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
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'description' => ['nullable', 'string', 'max:300'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Brand name is required',
            'logo.file' => 'Brand logo must be a file',
            'logo.mimes' => 'Brand logo must be a jpg, jpeg, or png file',
            'logo.max' => 'Brand logo must be less than 2MB',
            'description.max' => 'Brand description must be less than 300 characters',
            'is_active.boolean' => 'Brand status must be a boolean value'
        ];
    }
}
