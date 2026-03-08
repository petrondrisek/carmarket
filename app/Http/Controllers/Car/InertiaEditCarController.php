<?php
namespace App\Http\Controllers\Car;

use Inertia\Inertia;
use Inertia\Response;

use App\Models\Car;
use App\Http\Resources\Car\CarResource;

final class InertiaEditCarController
{
    public function __invoke(Car $car): Response
    {
        $car->load(['brand', 'images.image']);

        return Inertia::render('Car/Edit', [
            'car' => new CarResource($car),
        ]);
    }
}