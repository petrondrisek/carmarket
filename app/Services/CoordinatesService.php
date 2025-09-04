<?php
namespace App\Services;

class CoordinatesService
{
    /**
     * Count coordinates in radius.
     * 
     * @param float $lat
     * @param float $lng
     * @param int $radius
     * 
     * @return array: minLat, maxLat, minLng, maxLng
     */
    public function countCoordinatesInRadius(float $lat, float $lng, int $radius): array {
        $earthRadius = 6371;
        $latRadius = $radius / 111.32;
        $latRad = deg2rad($lat);
        $lngRadius = $radius / (111.32 * cos($latRad));

        return [
            'minLat' => $lat - $latRadius,
            'maxLat' => $lat + $latRadius,
            'minLng' => $lng - $lngRadius,
            'maxLng' => $lng + $lngRadius,
        ];
    }
}
