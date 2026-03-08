<?php
namespace App\Http\Controllers\Car;

use Inertia\Inertia;
use Inertia\Response;

use App\Dto\Car\FilterCarDto;
use App\Http\Requests\Car\FilterCarRequest;

final class InertiaSearchCarController
{
    public function __invoke(FilterCarRequest $request): Response
    {
        return Inertia::render(
            'Car/Search/Search', 
            ['queryParams' => FilterCarDto::fromRequest($request)->toArray()]
        );
    }
}