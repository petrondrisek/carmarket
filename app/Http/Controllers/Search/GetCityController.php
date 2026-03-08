<?php
namespace App\Http\Controllers\Search;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use App\Dto\Search\GetCityDto;
use App\Queries\Search\GetCityQuery;
use App\Http\Requests\Search\GetCityRequest;
use App\Http\Resources\Search\CityResource;


final class GetCityController
{
    public function __invoke(GetCityRequest $request, GetCityQuery $query): AnonymousResourceCollection
    {
        $response = $query->handle(GetCityDto::fromRequest($request));

        return CityResource::collection($response);
    }
}