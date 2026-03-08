<?php
namespace App\Queries\Brand;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Brand;
use App\Dto\Brand\GetBrandsDto;

final class ListBrandsQuery 
{
    public function handle(GetBrandsDto $dto): LengthAwarePaginator
    {
        return Brand::query()
            ->with(['images.image'])
            ->withCount('cars')
            ->when($dto->search, 
                fn ($q, $s) => $q->where('name', 'like', "%{$s}%")
            )
            ->where('is_active', $dto->onlyActive)
            ->orderBy('created_at', 'desc')
            ->paginate($dto->perPage)
            ->withQueryString();
    }
}