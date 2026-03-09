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
        $dto = GetBrandsDto::fromRequest($request);
        $dto->onlyActive = false;
        $brands = $query->handle($dto);

        return Inertia::render('Brand/Manage', [
            'brands' => BrandResource::collection($brands),
        ]);
    }
}