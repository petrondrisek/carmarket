<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

use App\Services\CarFilterService;

class DashboardController extends Controller
{
    /**
     * Render Inertia Dashboard page with Dashboard view.
     */
    public function index(CarFilterService $carFilterService): Response
    {
        return Inertia::render('Dashboard', [
            'cars' => $carFilterService->filterCars([], 6)
        ]);
    }
}
