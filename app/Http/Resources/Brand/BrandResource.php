<?php
namespace App\Http\Resources\Brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'logo' => $this->whenLoaded('images', function () {
                return $this->images->first()?->image?->public_path;
            }),
            'stats' => [
                'total_cars' => $this->cars_count,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'is_active' => $this->is_active
        ];
    }
}