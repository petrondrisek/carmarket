<?php
namespace App\Queries\Search;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\City;
use App\Dto\Search\GetCityDto;

final class GetCityQuery
{
    public function handle(GetCityDto $dto): LengthAwarePaginator
    {
        return City::query()
                ->where('aliases', 'like', "%{$dto->alias}%")
                ->paginate($dto->perPage)
                ->withQueryString();
    }
}