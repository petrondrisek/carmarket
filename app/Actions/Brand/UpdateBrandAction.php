<?php
namespace App\Actions\Brand;

use Illuminate\Support\Facades\{DB, Storage};

use App\Dto\Brand\UpdateBrandDto;
use App\Models\{Brand, Image, BrandImage};

final class UpdateBrandAction {
    public function execute(Brand $brand, UpdateBrandDto $updateBrandDto): Brand 
    {
        return DB::transaction(function () use ($brand, $updateBrandDto) {
            if($updateBrandDto->logo) {
                $file = Storage::putFile('temp', $updateBrandDto->logo->getPathname(), 'private');

                $oldLogoPath = BrandImage::with('image')->where('brand_id', $brand->id)->first();

                $newLogoPath = Image::create([
                    "temp_path" => $file,
                    "filename" => uniqid() . '.' .
                        $updateBrandDto->logo->getClientOriginalExtension(),
                    "folder" => "brand"
                ]);

                BrandImage::create(["brand_id" => $brand->id, "image_id" => $newLogoPath->id]);

                if($oldLogoPath && $oldLogoPath->image) 
                    $oldLogoPath->image->delete();
            }

            $brand->update([
                "name" => $updateBrandDto->name,
                "description" => $updateBrandDto->description,
                "is_active" => $updateBrandDto->isActive
            ]);

            return $brand;
        });
    }
}