<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateCarRequest extends FormRequest
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
        $car = $this->route('car');
        $car->loadMissing('images.image');
        
        $validUrls = $car->images->map(fn ($carImage) => $carImage->image->public_path)->toArray();
        
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
           'images_to_upload.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
           'images_to_delete' => ['nullable', 'array'],
           'images_to_delete.*' => ['string', function($value, $attribute, $fail) use ($validUrls) {
                if (!in_array($attribute, $validUrls)) {
                    $fail("File {$attribute} is not associated with this car and cannot be deleted.");
                }
           }],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $car = $this->route('car');
            $car->loadMissing('images.image');

            $newImages = $this->file('images_to_upload') ?? [];
            $imagesToDelete = $this->input('images_to_delete') ?? [];
            
            $existingImages = $car->images->map(fn ($carImage) => 
                asset('storage/' . $carImage->image->public_path)
            )->toArray();
            
            $currentCount = count($existingImages);
            $toDeleteCount = count($imagesToDelete);
            $toAddCount = count($newImages);

            if (($currentCount - $toDeleteCount + $toAddCount) > 6) {
                $validator->errors()->add('images_to_upload', 'Maximum number of images is 6.');
            }
        });
}
}
