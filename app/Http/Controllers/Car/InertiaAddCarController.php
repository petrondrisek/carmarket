<?php
namespace App\Http\Controllers\Car;

use Inertia\Inertia;
use Inertia\Response;

final class InertiaAddCarController
{
    public function __invoke(): Response
    {
        return Inertia::render('Car/Add');
    }
}