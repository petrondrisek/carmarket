<?php
namespace App\Actions\Car;

use Illuminate\Support\Facades\DB;

use App\Models\Car;

final class MarkAsSoldAction
{
    public function execute(Car $car): void
    {
        $car->update(['is_sold' => true]);
    }
}