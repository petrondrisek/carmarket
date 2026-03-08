<?php
namespace App\Http\Controllers\Car;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use App\Dto\Car\RegisterCarDto;
use App\Actions\Car\RegisterCarAction;
use App\Http\Requests\Car\RegisterCarRequest;

final class RegisterCarController
{
    public function __invoke(RegisterCarRequest $request, RegisterCarAction $action): RedirectResponse
    {
        $user = auth()->user();
        $car = $action->execute(RegisterCarDto::fromRequest($request), $user);

        return redirect()
                ->route('app_car_add')
                ->with('success', 'Car added successfully');
    }
}