<?php
namespace App\Services;

use App\Models\Car;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;


class CarService
{
    public function __construct(){}

    /** Deletes all cars by brand ID */
    public function deleteByBrand(int $brandId): bool {
        $cars = Car::where('brand_id', $brandId)->get();

        foreach ($cars as $car) {
            $carImages = json_decode($car->images);
            $this->deleteCarImages($car, $carImages, false);
            $car->delete();
        }

        return true;
    }

    /**
     * Deletes selected car images.
     * 
     * @param Car $car
     * @param array $images - Images to be deleted related to car.
     * @param bool $save - Whether to save changes to database (default: true).
     * 
     * @return bool
     */
    public function deleteCarImages(Car $car, array $images, bool $save = true): bool {
        $carImages = json_decode($car->images);

        if (count($carImages) > 0) {
            foreach ($images as $image) {
                if(!in_array($image, $carImages)) {
                    continue;
                }

                Storage::disk('public')->delete($image);
                $car->images = json_encode( array_diff($carImages, [$image]) );
            }
        }

        if($save)
            $car->save();

        return true;
    }

    /** Creates a new car */
    public function create(array $data): Car 
    {
        $imagesUrl = [];
        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                if ($image instanceof UploadedFile) {
                    $imagesUrl[] = $image->store('cars', 'public');
                }
            }
        }

        $carData = [
            ...$data,
            'user_id' => auth()->user()->id,
            'locationLat' => $data['location']['lat'] ?? 0,
            'locationLng' => $data['location']['lng'] ?? 0,
            'images' => json_encode($imagesUrl),
            'other_features' => json_encode($data['other_features'] ?? []),
            'is_sold' => false
        ];
        unset($carData['location']);

        $car = Car::create($carData);
        return $car;
    }

    /** Gets car with calculated city from lat and lng coordinates */
    public function getCarWithCity(int $id): ?Car
    {
        return Car::with(['brand', 'user'])
                    ->select('cars.*')
                    ->addSelect([
                        'city_name' => function ($query) {
                            $query->select('cities.name')
                                ->from('cities')
                                ->orderByRaw('
                                    SQRT(
                                        POW(cities.lat - cars.locationLat, 2) +
                                        POW(cities.lng - cars.locationLng, 2)
                                    )
                                ')
                                ->limit(1);
                        }
                    ])
                    ->find($id);
    }

    /** Deletes car from database */
    public function deleteCar(Car $car): void
    {
        $carImages = json_decode($car->images);
        $this->deleteCarImages($car, $carImages);

        $car->delete();
    }

    /** Updates car in database */
    public function updateCar(Car $car, array $data): Car 
    {     
        $existingImages = json_decode($car->images, true) ?: [];

        // Delete unwanted images - if any (user selected to delete)
        if (!empty($data['images_to_delete'])) {
            $this->deleteCarImages($car, $data['images_to_delete']);

            $existingImages = array_filter($existingImages, function ($image) use ($data) {
                return !in_array($image, $data['images_to_delete']);
            });
        }

        // Upload new images
        $newImages = [];
        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                if ($image instanceof UploadedFile) {
                    $newImages[] = $image->store('cars', 'public');
                }
            }
        }

        $allImages = array_merge($existingImages, $newImages);

        $carData = [
            ...$data,
            'locationLat' => $data['location']['lat'] ?? 0,
            'locationLng' => $data['location']['lng'] ?? 0,
            'images' => json_encode($allImages),
            'other_features' => json_encode($data['other_features'] ?? []),
        ];
        unset($carData['location'], $carData['images_to_delete']);

        $car->update($carData);
        return $car;
    }

    /** Marks car as sold */
    public function markAsSold(Car $car): void 
    {
        $car->is_sold = true;
        $car->save();
    }
}