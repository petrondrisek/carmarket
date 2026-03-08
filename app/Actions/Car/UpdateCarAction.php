<?php
namespace App\Actions\Car;

use Illuminate\Support\Facades\{DB, Storage};

use App\Models\{Car, CarImage, Image};
use App\Dto\Car\UpdateCarDto;

final class UpdateCarAction
{
    public function execute(Car $car, UpdateCarDto $data): Car
    {
        return DB::transaction(function () use ($car, $data) {
            $car->update([
                'brand_id' => $data->brandId,
                'model' => $data->model,
                'color' => $data->color,
                'location_lat' => $data->location->lat,
                'location_lng' => $data->location->lng,
                'location_name' => $data->location->name,
                'kilometers' => $data->kilometers,
                'price' => $data->price,
                'engine' => $data->engine->value,
                'state' => $data->state->value,
                'transmission' => $data->transmission->value,
                'year' => $data->year,
                'fuel_consumption' => $data->fuelConsumption,
                'description' => $data->description,
                'other_features' => $data->otherFeatures, 
            ]);

            // Images
            // Delete
            if (!empty($data->deletedImages)) {
                foreach ($data->deletedImages as $path) {
                    Image::where('public_path', $path)->each(function ($img) { 
                        $img->delete(); 
                    });
                }
            }

            // Upload
            if (!empty($data->images)) {
                foreach ($data->images as $image) {
                    $file = Storage::putFile('temp', $image->getPathname(), 'private');

                    $img = Image::create([
                        'temp_path' => $file,
                        'filename' => uniqid() . '.' .
                            $image->getClientOriginalExtension(),
                        'folder' => "brand_{$data->brandId}/car_{$car->id}"
                    ]);

                    CarImage::create(['car_id' => $car->id, 'image_id' => $img->id]);
                }
            }

            return $car;
        });
    }
}