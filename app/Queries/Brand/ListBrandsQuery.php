<?php
namespace App\Queries\Brand;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Brand;
use App\Dto\Brand\GetBrandsDto;

final class ListBrandsQuery 
{
    public function handle(GetBrandsDto $dto): LengthAwarePaginator
    {
        $query = Brand::query()
            ->with(['images.image'])
            ->withCount('cars')
            ->when($dto->search, 
                fn ($q, $s) => $q->where('name', 'like', "%{$s}%")
            );
            
        if($dto->onlyActive) {
            $query = $query->where('is_active', $dto->onlyActive);
        }

        $query = $query->orderBy('created_at', 'desc')
                        ->paginate($dto->perPage)
                        ->withQueryString();

        return $query;
    }
}