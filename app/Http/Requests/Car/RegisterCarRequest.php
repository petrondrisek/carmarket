<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterCarRequest extends FormRequest
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
           'brand_id' => ['required', 'exists:brands,id'],
           'model' => ['required', 'string', 'max:255'],
           'color' => ['required', 'string', 'max:255'],
           'location' => ['required', 'array'],
           'location.lat' => ['required', 'numeric'],
           'location.lng' => ['required', 'numeric'],
           'kilometers' => ['required', 'numeric'],
           'price' => ['required', 'numeric'],
           'engine' => ['required', new Enum(\App\Types\Car\EngineType::class)],
           'state' => ['required', new Enum(\App\Types\Car\StateType::class)],
           'transmission' => ['required', new Enum(\App\Types\Car\TransmissionType::class)],
           'year' => ['required', 'date_format:Y', 'after:1900'],
           'fuel_consumption' => ['nullable', 'numeric'],
           'description' => ['required', 'string', 'max:500'],
           'other_features' => ['nullable', 'array'],
           'images_to_upload' => ['nullable', 'array', 'max:6'],
           'images_to_upload.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048']
        ];
    }
}
