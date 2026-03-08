<?php
namespace App\Http\Controllers\Car;

use Illuminate\Http\RedirectResponse;

use App\Models\Car;
use App\Actions\Car\MarkAsSoldAction;

final class MarkAsSoldCarController
{
    public function __invoke(Car $car, MarkAsSoldAction $action): RedirectResponse
    {
        $action->execute($car);

        return redirect()
                ->route('app_car_get')
                ->with('success', 'Car marked as sold successfully.');
    }
}