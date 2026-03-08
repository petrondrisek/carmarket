<?php
namespace App\Dto\Brand;

use App\Http\Requests\Brand\GetBrandsRequest;

final class GetBrandsDto
{
    public function __construct(
        public int $perPage = 10,
        public int $page = 1,
        public ?string $search = null,
        public bool $onlyActive = true
    ) {}

    public static function fromRequest(GetBrandsRequest $request): self
    {
        return new self(
            (int)($request->validated()['per_page'] ?? 10),
            (int)($request->validated()['page'] ?? 1),
            $request->validated()['search'] ?? null,
            (bool)($request->validated()['only_active'] ?? true)
        );
    }
}