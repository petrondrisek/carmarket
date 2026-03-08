<?php
namespace App\Actions\Car;

use Illuminate\Support\Facades\{DB, Storage};

use App\Models\{Car, Image};

final class DeleteCarAction
{
    public function execute(Car $car): void
    {
        $directoryPath = "brand_{$car->brand->id}/car_{$car->id}";

        DB::transaction(function () use ($car, $directoryPath) {
            Image::where('folder', 'like', "{$directoryPath}%")->delete(); // won't run dispatch events

            $car->delete();

            DB::afterCommit(function () use($car, $directoryPath) {
                Storage::disk('public')->deleteDirectory($directoryPath);
            });
        });
    }
}