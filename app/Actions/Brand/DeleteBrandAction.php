<?php
namespace App\Actions\Brand;

use Illuminate\Support\Facades\{DB, Storage};
use App\Models\{Brand, Image};

class DeleteBrandAction
{
    public function execute(Brand $brand): void
    {
        $directoryPath = "brand_{$brand->id}";

        DB::transaction(function () use ($brand, $directoryPath) {
            $brand->images?->each(function ($brandImage) {
                $brandImage->image?->delete();
            });
            
            Image::where('folder', 'like', "{$directoryPath}%")->delete(); // won't run dispatch events
            
            $brand->delete();

            DB::afterCommit(function () use ($brand, $directoryPath) { 
                Storage::disk('public')->deleteDirectory($directoryPath);
            });
        });
    }
}