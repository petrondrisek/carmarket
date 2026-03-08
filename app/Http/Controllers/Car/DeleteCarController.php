<?php
namespace App\Http\Controllers\Car;

use Illuminate\Http\RedirectResponse;

use App\Models\Car;
use App\Actions\Car\DeleteCarAction;

final class DeleteCarController
{
    public function __invoke(Car $car, DeleteCarAction $action): RedirectResponse
    {
        $car->load(['brand']);
        
        $action->execute($car);

        return redirect()
                ->route('app_car_get')
                ->with('success', 'Car deleted successfully.');
    }
}