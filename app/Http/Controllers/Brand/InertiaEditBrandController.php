<?php
namespace App\Http\Controllers\Brand;

use Inertia\Inertia;
use Inertia\Response;

use App\Models\Brand;
use App\Http\Resources\Brand\BrandResource;

final class InertiaEditBrandController
{
    public function __invoke(Brand $brand): Response
    {
        $brand->load('images.image');
        
        return Inertia::render('Brand/Edit', ['brand' => new BrandResource($brand)]);
    }
}