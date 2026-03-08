<?php
namespace App\Http\Controllers\Car;

use Inertia\Inertia;
use Inertia\Response;

use App\Dto\Car\FilterCarDto;
use App\Queries\Car\ListFilterCarsQuery;
use App\Http\Resources\Car\CarResource;
use App\Http\Requests\Car\FilterCarRequest;

final class InertiaFilterCarController
{
    public function __invoke(FilterCarRequest $request, ListFilterCarsQuery $query): Response
    {
        $dto = FilterCarDto::fromRequest($request);
        $cars = $query->handle($dto);

        return Inertia::render('Car/List', [
            'cars' => CarResource::collection($cars),
            'queryParams' => $dto->toArray()
        ]);
    }
}