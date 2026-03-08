<?php
namespace App\Queries\Car;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Models\Car;

final class ListCarsQuery
{
    public function handle(int $perPage = 10): LengthAwarePaginator
    {
        // closest_city is an accessor, so we need to load it for each car
        $cars = Car::query()
            ->with(['brand', 'user', 'images.image'])
            ->where('is_sold', false)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        return $cars;
    }
}