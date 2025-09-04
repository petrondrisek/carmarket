<?php

namespace App\Listeners;

use App\Events\BrandDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\CarService;

class DeleteCarsByBrand
{

    public function __construct(
        private CarService $carService
    )
    {}

    public function handle(BrandDeleted $event): void
    {
        $this->carService->deleteByBrand($event->brand->id);
    }
}
