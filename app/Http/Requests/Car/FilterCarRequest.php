<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

// log
use Illuminate\Support\Facades\Log;

class FilterCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $map = [
            'b'  => 'brand',
            'c'  => 'color',
            't'  => 'transmission',
            'p'  => 'price',
            'y'  => 'year',
            'km' => 'kilometers',
            'e'  => 'engine',
            'r'  => 'radius',
            's'  => 'state',
            'f'  => 'fuel_consumption',
            'w'  => 'whole_republic',
            'lat'=> 'lat',
            'lng'=> 'lng',
        ];

        $filters = [];
        foreach ($map as $short => $long) {
            if ($this->filled($short)) {
                $value = $this->query($short);
                $decoded = str_contains($value, ',') ? explode(',', $value) : $value;
                
                $shouldBeArray = in_array($long, ['brand', 'color', 'price', 'year', 'kilometers']);
                $filters[$long] = $shouldBeArray ? (is_array($decoded) ? $decoded : [$decoded]) : $decoded;
            }
        }

        // Location
        if (isset($filters['radius'], $filters['lat'], $filters['lng']) && !$filters['whole_republic']) {
            $filters['location'] = [
                'radius' => $filters['radius'],
                'lat' => $filters['lat'],
                'lng' => $filters['lng'],
            ];
        }
        
        unset($filters['radius'], $filters['lat'], $filters['lng']);

        Log::debug(json_encode($filters));
        $this->merge(['filters' => $filters]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filters.brand' => ['nullable'],
            'filters.brand.*' => ['exists:brands,id'],
            
            'filters.color' => ['nullable'],
            'filters.color.*' => ['string'],
            
            'filters.transmission' => ['nullable', new Enum(\App\Types\Car\TransmissionType::class)],
            
            'filters.state' => ['nullable', new Enum(\App\Types\Car\StateType::class)],
            
            'filters.price' => ['nullable'],
            'filters.price.*' => ['numeric'],
            
            'filters.year' => ['nullable'],
            'filters.year.*' => ['numeric'],

            'filters.location' => ['nullable', 'array'],
            'filters.location.radius' => ['required_with:filters.location.lat,filters.location.lng', 'numeric'],
            'filters.location.lat' => ['required_with:filters.location.radius,filters.location.lng', 'numeric'],
            'filters.location.lng' => ['required_with:filters.location.radius,filters.location.lat', 'numeric'],
            
            'filters.kilometers' => ['nullable'],
            'filters.kilometers.*' => ['numeric'],
            
            'filters.engine' => ['nullable', new Enum(\App\Types\Car\EngineType::class)],
            
            'filters.fuel_consumption' => ['nullable', 'numeric'],

            'filters.state' => ['nullable', new Enum(\App\Types\Car\StateType::class)],
            
            'filters.page' => ['nullable', 'numeric', 'min:1'],
            
            'filters.limit' => ['nullable', 'numeric', 'min:10'],

            'filters.whole_republic' => ['nullable', 'boolean'],
        ];
    }
}
