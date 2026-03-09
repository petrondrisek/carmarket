<?php
namespace App\Actions\Car;

use Illuminate\Support\Facades\{DB, Storage, Log};
use App\Models\{Car, Brand, User, Image, CarImage};
use App\Dto\Car\RegisterCarDto;

final class RegisterCarAction
{
    public function execute(RegisterCarDto $data, User $user): Car
    {
        Log::info(json_encode($data));

        // check brand
        $brand = Brand::findOrFail($data->brandId);
        if($brand->is_active == false) {
            throw new \Exception('Brand is not active');
        }

        return DB::transaction(function () use ($data, $user) {
            $car = Car::create([
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
                'user_id' => $user->id,
                'other_features' => json_encode($data->otherFeatures),
            ]);

            if ($data->images) {
                foreach ($data->images as $image) {
                    $file = Storage::putFile('temp', $image->getPathname(), 'private');

                    $img = Image::create([
                        "folder" => "brand_{$data->brandId}/car_{$car->id}",
                        "filename" => uniqid() . '.' .
                            $image->getClientOriginalExtension(),
                        "temp_path" => $file,
                    ]);

                    CarImage::create(["car_id" => $car->id, "image_id" => $img->id]);
                }
            }
            return $car;
        });
    }
}