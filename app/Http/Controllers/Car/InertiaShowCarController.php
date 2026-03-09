<?php
namespace App\Http\Controllers\Car;

use Inertia\Inertia;
use Inertia\Response;

use App\Models\Car;
use App\Models\Brand;
use App\Models\User;
use App\Http\Resources\Car\CarResource;
use App\Http\Resources\Brand\BrandResource;

final class InertiaShowCarController
{
    public function __invoke(Car $car): Response
    {
        $car->load(['brand', 'brand.images.image', 'user', 'images.image']);

        return Inertia::render('Car/Show', [
            'car' => new CarResource($car)
        ]);
    }
}