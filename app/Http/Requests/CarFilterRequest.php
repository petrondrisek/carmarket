<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotLessThan;

class CarFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * 
     * Laravel will call this method before validation automatically.
     */
    public function prepareForValidation()
    {
        if ($this->has('q')) {
            $decoded = urldecode(base64_decode($this->query('q')));
            $json = json_decode($decoded, true);

            $this->merge(['filters' => $json ?: []]);
        } else {
            $this->merge(['filters' => []]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'filters.brand_id' => ['nullable', 'exists:brands,id'],
           'filters.color' => ['nullable', 'string', 'max:255'],
           'filters.transmission' => ['nullable', 'in:manual,automatic'],
           'filters.state' => ['nullable', 'in:new,used,refurbished'],
           'filters.min_price' => ['nullable', 'numeric', 'min:0'],
           'filters.max_price' => ['nullable', 'numeric', new NotLessThan('min_price')],
           'filters.min_year' => ['nullable', 'integer', 'min:0'],
           'filters.max_year' => ['nullable', 'integer', new NotLessThan('min_year')],
           'filters.radius' => ['nullable', 'numeric'],
           'filters.lat' => ['nullable', 'numeric'],
           'filters.lng' => ['nullable', 'numeric'],
           'filters.kilometers' => ['nullable', 'numeric'],
           'filters.engine' => ['nullable', 'in:diesel,gasoline,hybrid,electric,lpg,cng'],
           'filters.fuel_consumption' => ['nullable', 'numeric'],
           'filters.page' => ['nullable', 'numeric', 'min:1'],
        ];
    }
}
