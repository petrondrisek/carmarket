<?php
namespace App\Http\Controllers\Brand;

use Inertia\Inertia;
use Inertia\Response;

use App\Dto\Brand\GetBrandsDto;
use App\Queries\Brand\ListBrandsQuery;
use App\Http\Requests\Brand\GetBrandsRequest;
use App\Http\Resources\Brand\BrandResource;

final class InertiaManageBrandsController
{
    public function __invoke(GetBrandsRequest $request, ListBrandsQuery $query): Response
    {
        $brands = $query->handle(GetBrandsDto::fromRequest($request));

        return Inertia::render('Brand/Manage', [
            'brands' => BrandResource::collection($brands),
        ]);
    }
}