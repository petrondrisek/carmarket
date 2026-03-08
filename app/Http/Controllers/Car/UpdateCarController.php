<?php
namespace App\Http\Controllers\Car;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use App\Models\Car;
use App\Dto\Car\UpdateCarDto;
use App\Actions\Car\UpdateCarAction;
use App\Http\Requests\Car\UpdateCarRequest;

final class UpdateCarController
{
    public function __invoke(Car $car, UpdateCarRequest $request, UpdateCarAction $action): RedirectResponse
    {
        $car = $action->execute($car, UpdateCarDto::fromRequest($request));

        return redirect()
                ->route('app_car_get')
                ->with('success', 'Car updated successfully');
    }
}