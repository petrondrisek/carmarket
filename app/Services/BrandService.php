<?php
namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    /** Creates a new brand. */
    public function create(array $data): Brand 
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile)
            $data['logo'] = $data['logo']->store('logos', 'public');

        $brand = Brand::create($data);
        return $brand;
    }

    /**
     * Returns all brands with cars count.
     * 
     * @param int $paginate: number of items per page
     * 
     * @return Brand[]
     */
    public function list(int $paginate): LengthAwarePaginator 
    {
        return Brand::select('*')
                    ->addSelect([
                        'cars_count' => function ($query) {
                            $query->selectRaw('COUNT(*)')
                                ->from('cars')
                                ->whereColumn('brand_id', 'brands.id');
                        }
                    ])
                    ->orderBy('created_at', 'desc')->paginate($paginate)->withQueryString();
    }

    /** Update brand details and handle logo upload/removal */
    public function update(Brand $brand, array $data): Brand
    {
        if (isset($data['logo']) && $data['logo'] instanceof UploadedFile) {
            if ($brand->logo)
                Storage::disk('public')->delete($brand->logo);

            $data['logo'] = $data['logo']->store('logos', 'public');
        } else {
            unset($data['logo']);
        }

        $brand->fill([
            'name' => $data['name'] ?? $brand->name,
            'description' => $data['description'] ?? '',
            'is_active' => $data['is_active'] ?? false,
            'logo' => $data['logo'] ?? $brand->logo,
        ])->save();

        return $brand;
    }

    /** Deletes a brand. */
    public function delete(Brand $brand): void
    {
        if ($brand->logo)
            Storage::disk('public')->delete($brand->logo);

        $brand->delete();
    }

    /** Returns all active brands, API endpoint */
    public function getAllActive(): Collection
    {
        return Brand::where('is_active', true)->get();
    }
}