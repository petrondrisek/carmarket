<?php
namespace App\Http\Controllers\Brand;

use Inertia\Inertia;
use Inertia\Response;

final class InertiaAddBrandController
{
    public function __invoke(): Response
    {
        return Inertia::render('Brand/Add');
    }
}