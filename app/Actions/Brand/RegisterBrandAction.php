<?php
namespace App\Actions\Brand;

use Illuminate\Support\Facades\{DB, Storage};

use App\Models\{Brand, BrandImage, Image};
use App\Dto\Brand\RegisterBrandDto;
use App\Jobs\ProcessImageUpload;

final class RegisterBrandAction {
    public function execute(RegisterBrandDto $dto): Brand
    {        
        return DB::transaction(function () use ($dto) {
            $brand = Brand::create([
                "name" => $dto->name,
                "description" => $dto->description,
                "is_active" => $dto->isActive
            ]);

            if($dto->logo) {
                $file = Storage::putFile('temp', $dto->logo->getPathname(), 'private');

                $image = Image::create([
                    "temp_path" => $file,
                    "filename" => uniqid() . '.' .
                        $dto->logo->getClientOriginalExtension(),
                    "folder" => "brand"
                ]);

                BrandImage::create(["brand_id" => $brand->id, "image_id" => $image->id]);
            }
            return $brand;
        });
    }
}