<?php
namespace App\Http\Resources\Car;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\Image\ImageResource;
use App\Http\Resources\User\UserResource;

class CarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'user' => new UserResource($this->whenLoaded('user')),
            'model' => $this->model,
            'description' => $this->description,
            'color' => $this->color,
            'transmission' => $this->transmission,
            'engine' => $this->engine,
            'state' => $this->state,
            'fuel_consumption' => $this->fuel_consumption,
            'other_features' => json_decode($this->other_features, true) ?? [],
            'year' => $this->year,
            'price' => $this->price,
            'kilometers' => $this->kilometers,
            'images' => $this->whenLoaded('images', function () {
                return $this->images
                        ->pluck('image')
                        ->map(fn ($img) => $img->public_path);
            }),
            'location' => [
                'city' => $this->closest_city,
                'lat' => (float)$this->location_lat,
                'lng' => (float)$this->location_lng,
            ],
            'is_new' => $this->created_at->diffInDays() < 7,
        ];
    }
}