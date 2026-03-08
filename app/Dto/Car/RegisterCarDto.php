<?php
namespace App\Dto\Car;

use App\Http\Requests\Car\RegisterCarRequest;
use App\Types\Car\EngineType;
use App\Types\Car\StateType;
use App\Types\Car\TransmissionType;
use App\Types\Car\Location;

readonly class RegisterCarDto {
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
        public ?array $images
    ) {}

    public static function fromRequest(RegisterCarRequest $request): self {
        return new self(
            brandId: $request->input('brand_id'),
            model: $request->input('model'),
            color: $request->input('color'),
            location: new Location(
                lat: $request->input('location.lat'),
                lng: $request->input('location.lng'),
                name: $request->input('location.name')
            ),
            kilometers: $request->input('kilometers'),
            price: $request->input('price'),
            engine: EngineType::from($request->input('engine')),
            state: StateType::from($request->input('state')),
            transmission: TransmissionType::from($request->input('transmission')),
            year: (int) $request->input('year'),
            fuelConsumption: (float) $request->input('fuel_consumption', 0),
            description: $request->input('description'),
            otherFeatures: $request->input('other_features', []),
            images: $request->file('images_to_upload', [])
        );
    }
}