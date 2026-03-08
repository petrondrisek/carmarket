<?php
namespace App\Queries\Car;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use App\Models\Car;
use App\Dto\Car\FilterCarDto;

final class ListFilterCarsQuery 
{
    public function handle(FilterCarDto $dto): LengthAwarePaginator
    {
        return $cars = Car::query()
                ->with(['brand', 'images.image', 'user'])
                ->when($dto->brandIds, fn($q, $b) => $q->whereIn('brand_id', $b))
                ->when($dto->colors, fn($q, $c) => $q->whereIn('color', $c))
                ->when($dto->transmission, fn($q, $t) => $q->where('transmission', $t))
                ->when($dto->minPrice, fn($q, $p) => $q->where('price', '>=', $p))
                ->when($dto->maxPrice, fn($q, $p) => $q->where('price', '<=', $p))
                ->when($dto->minYear, fn($q, $y) => $q->where('year', '>=', $y))
                ->when($dto->maxYear, fn($q, $y) => $q->where('year', '<=', $y))
                ->when($dto->location, fn($q, $l) => $q->whereInRadius($l))
                ->when($dto->minKilometers, fn($q, $km) => $q->where('kilometers', '>=', $km))
                ->when($dto->maxKilometers, fn($q, $km) => $q->where('kilometers', '<=', $km))
                ->when($dto->engines, fn($q, $e) => $q->whereIn('engine', $e))
                ->when($dto->maxFuelConsumption, fn($q, $fc) => $q->where('fuel_consumption', '<=', $fc))
                ->when($dto->state, fn($q, $s) => $q->where('state', $s))
                ->where('is_sold', false)
                ->orderBy('created_at', 'desc')
                ->paginate($dto->limit, ['*'], 'page', $dto->page)
                ->withQueryString();
    }
}