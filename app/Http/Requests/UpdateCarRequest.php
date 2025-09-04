<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
           'brand_id' => ['required', 'exists:brands,id'],
           'model' => ['required', 'string', 'max:255'],
           'color' => ['required', 'string', 'max:255'],
           'location' => ['required', 'array'],
           'location.name' => ['required', 'string', 'max:255', 'exists:cities,name'],
           'location.lat' => ['required', 'numeric'],
           'location.lng' => ['required', 'numeric'],
           'kilometers' => ['required', 'numeric'],
           'price' => ['required', 'numeric'],
           'engine' => ['required', 'in:diesel,gasoline,hybrid,electric,lpg,cng'],
           'state' => ['required', 'in:new,used,refurbished'],
           'transmission' => ['required', 'in:manual,automatic'],
           'year' => ['required', 'date_format:Y', 'after:1900'],
           'fuel_consumption' => ['nullable', 'numeric'],
           'description' => ['required', 'string', 'max:500'],
           'other_features' => ['nullable', 'array'],
           'images' => ['nullable', 'array', 'max:6'],
           'images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
           'images_to_delete' => ['nullable', 'array'],
           'images_to_delete.*' => ['string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /** @var \App\Models\Car $car */
            $car = $this->route('car');

            if (!$car) {
                $validator->errors()->add('images', 'Car not found for validation.');
                return;
            }

            $images = $this->all()['images'] ?? [];
            $imagesToDelete = $this->all()['images_to_delete'] ?? [];
            
            $existingImagesCount = count(json_decode($car->images, true) ?: []);
            $newImagesCount = count($images);
            $imagesToDeleteCount = count($imagesToDelete);

            if ($existingImagesCount - $imagesToDeleteCount + $newImagesCount > 6) {
                $validator->errors()->add('images', 'You can have maximum 6 images per car.');
            }
        });
    }
}
