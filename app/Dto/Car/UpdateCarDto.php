<?php
namespace App\Dto\Car;

use App\Http\Requests\Car\UpdateCarRequest;
use App\Types\Car\EngineType;
use App\Types\Car\StateType;
use App\Types\Car\TransmissionType;
use App\Types\Car\Location;

readonly class UpdateCarDto {
    public function __construct(
        public int $brandId,
        public string $model,
        public string $color,
        public Location $location,
        public int $kilometers,
        public int $price,
        public EngineType $engine,
        public StateType $state,
        public TransmissionType $transmission,
        public int $year,
        public float $fuelConsumption,
        public string $description,
        public ?array $otherFeatures,
        public ?array $images,
        public ?array $deletedImages
    ) {}

    public static function fromRequest(UpdateCarRequest $request): self {
        return new self(
            brandId: $request->validated('brand_id'),
            model: $request->validated('model'),
            color: $request->validated('color'),
            location: new Location(
                lat: $request->validated('location.lat'),
                lng: $request->validated('location.lng'),
                name: $request->validated('location.name')
            ),
            kilometers: $request->validated('kilometers'),
            price: $request->validated('price'),
            engine: EngineType::from($request->validated('engine')),
            state: StateType::from($request->validated('state')),
            transmission: TransmissionType::from($request->validated('transmission')),
            year: (int) $request->validated('year'),
            fuelConsumption: (float) $request->validated('fuel_consumption', 0),
            description: $request->validated('description'),
            otherFeatures: $request->validated('other_features', []),
            images: $request->file('images_to_upload', []),
            deletedImages: $request->validated('images_to_delete', [])
        );
    }
}