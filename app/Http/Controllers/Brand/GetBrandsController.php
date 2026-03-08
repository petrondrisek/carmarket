<?php
namespace App\Http\Controllers\Brand;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use App\Dto\Brand\GetBrandsDto;
use App\Queries\Brand\ListBrandsQuery;
use App\Http\Resources\Brand\BrandResource;
use App\Http\Requests\Brand\GetBrandsRequest;

final class GetBrandsController
{
    public function __invoke(GetBrandsRequest $request, ListBrandsQuery $query): AnonymousResourceCollection
    {
        $brands = $query->handle(GetBrandsDto::fromRequest($request));

        return BrandResource::collection($brands);
    }
}