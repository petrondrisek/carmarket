<?php
namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Inertia\Response;

use App\Queries\Car\ListCarsQuery;
use App\Http\Resources\Car\CarResource;

final class InertiaDashboardController {
    public function __invoke(ListCarsQuery $query): Response
    {
        $cars = $query->handle(6);

        return Inertia::render('Dashboard/Dashboard', [
            'cars' => CarResource::collection($cars),
        ]);
    }
}