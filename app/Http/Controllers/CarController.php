<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Brand;
use App\Models\Car;
use App\Services\CarService;
use App\Services\CarFilterService;
use App\Http\Requests\CarFilterRequest;
use App\Http\Requests\RegisterCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarController extends Controller
{
    public function __construct(
        private readonly CarService $carService
    ) {}

    /** Add a new car, FE rendering Inertia Car/Add */
    public function add(): Response {
        return Inertia::render('Car/Add');
    }

    /** FE: Renders Inertia Car/List to display cars based on query filters. */
    public function list(CarFilterRequest $request, CarFilterService $carFilterService): Response 
    {
        $filters = $request->input('filters') ?? [];
        $cars = $carFilterService->filterCars($filters, 6);

        return Inertia::render('Car/List', [
            'cars' => $cars,
            'queryParams' => $filters
        ]);
    }

    /** FE: Renders Inertia Car/Show to display car details. */
    public function show(int $carId): Response {
        $car = $this->carService->getCarWithCity($carId);
        if(!$car) abort(404);

        return Inertia::render('Car/Show', [
            'car' => $car,
            'brand' => Brand::find($car->brand_id),
            'user' => User::find($car->user_id)
        ]);
    }

    /** BE: Adds new car to database. */
    public function store(RegisterCarRequest $request): RedirectResponse 
    {
        $data = $request->validated();
        $this->carService->create($data);

        return redirect()
                ->route('app_car_add')
                ->with('success', 'Car added successfully');
    }

    /** FE: Renders Inertia Car/Edit to edit car details. */
    public function edit(int $carId): Response {
        $car = $this->carService->getCarWithCity($carId);
        
        if(!$car) abort(404);

        return Inertia::render('Car/Edit', [
            'car' => $car
        ]);
    }

    /** BE: Updates car in database. */
    public function update(UpdateCarRequest $request, Car $car): RedirectResponse 
    {
        $data = $request->validated();
        $this->carService->updateCar($car, $data);

        return redirect()
                ->route('app_car_get')
                ->with('success', 'Car updated successfully');
    }

    /** Deletes car from database, DELETE request. */
    public function destroy(Car $car): RedirectResponse {
        $this->carService->deleteCar($car);

        return redirect()
                ->route('app_car_get')
                ->with('success', 'Car deleted successfully.');
    }

    public function sold(Car $car): RedirectResponse {
        $this->carService->markAsSold($car);

        return redirect()
                ->route('app_car_get')
                ->with('success', 'Car marked as sold successfully.');
    }
}
