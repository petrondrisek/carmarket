<?php
namespace App\Http\Resources\Search;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'city' => $this->name,
            'state' => $this->state,
            'lat' => $this->lat,
            'lng' => $this->lng
        ];
    }
}