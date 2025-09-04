<?php
namespace App\Services;

use App\Models\Car;

class CarFilterService
{
    public function __construct(private CoordinatesService $coordinatesService){}

    /** Filters cars based on query parameters (Request - CarFilterRequest) */
    public function filterCars(array $queryParams, int $limit) {
        $carsQuery = Car::with(['brand', 'user'])
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
                        ->distinct();

        $compareEqual = ["brand_id", "color", "transmission", "state", "engine"];
        foreach($compareEqual as $param) {
            if (isset($queryParams[$param]) && !empty($queryParams[$param])) {
                $carsQuery->where($param, $queryParams[$param]);
            }
        }

        $compareBetween = [["min_price", "max_price", "price"], ["min_year", "max_year", "year"]];
        foreach($compareBetween as $param) {
            if (isset($queryParams[$param[0]]) || isset($queryParams[$param[1]])) {
                $min = isset($queryParams[$param[0]]) && !empty($queryParams[$param[0]]) ? $queryParams[$param[0]] : 0;
                $max = isset($queryParams[$param[1]]) && !empty($queryParams[$param[1]]) ? $queryParams[$param[1]] : PHP_INT_MAX;

                $carsQuery->whereBetween($param[2], [$min, $max]);
            }
        }

        $compareLessOrEqual = ["kilometers", "fuel_consumption"];
        foreach($compareLessOrEqual as $param) {
            if (isset($queryParams[$param]) && !empty($queryParams[$param])) {
                $carsQuery->where($param, "<=", $queryParams[$param]);
            }
        }

        if (isset($queryParams['lat']) && isset($queryParams['lng']) && isset($queryParams['radius'])) {
            $lat = $queryParams['lat'];
            $lng = $queryParams['lng'];
            $radius = $queryParams['radius'];

            $coordinates = $this->coordinatesService->countCoordinatesInRadius($lat, $lng, $radius);

            $carsQuery->whereBetween('locationLat', [$coordinates['minLat'], $coordinates['maxLat']])
                ->whereBetween('locationLng', [$coordinates['minLng'], $coordinates['maxLng']]);
        }

        $cars = $carsQuery->where('is_sold', false)
                ->orderBy('created_at', 'desc')
                ->paginate($limit, ['*'], 'page', $queryParams['page'] ?? 1)
                ->through(function($car) {
                    $car->images = json_decode($car->images);
                    $car->other_features = json_decode($car->other_features, true);
                    $car->price = number_format($car->price, 2);
                    $car->kilometers = number_format($car->kilometers, 0);

                    return $car;
                })
                ->withQueryString();

        return $cars;
    }
}