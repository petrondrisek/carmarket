<?php
namespace App\Dto\Search;

use App\Http\Requests\Search\GetCityRequest;

final class GetCityDto
{
    public function __construct(
        public string $alias,
        public int $perPage = 10,
        public int $page = 1
    ) {}

    public static function fromRequest(GetCityRequest $request): self
    {
        return new self(
            $request->validated()['alias'],
            (int)($request->validated()['per_page'] ?? 10),
            (int)($request->validated()['page'] ?? 1),
        );
    }
}