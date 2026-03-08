<?php
namespace App\Dto\Car;

use App\Http\Requests\Car\FilterCarRequest;
use App\Types\Car\EngineType;
use App\Types\Car\TransmissionType;
use App\Types\Car\Location;
use App\Types\Car\StateType;

readonly class FilterCarDto
{
    public function __construct(
        public ?array $brandIds,
        public ?array $colors,
        public ?TransmissionType $transmission,
        public ?int $minPrice,
        public ?int $maxPrice,
        public ?int $minYear,
        public ?int $maxYear,
        public ?Location $location,
        public ?int $minKilometers,
        public ?int $maxKilometers,
        public ?array $engines,
        public ?int $maxFuelConsumption,
        public ?StateType $state,
        public ?int $page,
        public ?int $limit,
    ) {}

    public static function fromRequest(FilterCarRequest $request): self
    {
        $filters = $request->validated('filters') ?? [];

        $getRange = function($key, $index) use ($filters) {
            return isset($filters[$key][$index]) && $filters[$key][$index] !== '' 
                ? (int)$filters[$key][$index] 
                : null;
        };

        return new self(
            brandIds: $filters['brand'] ?? null,
            
            colors: $filters['color'] ?? null,
            
            transmission: isset($filters['transmission']) 
                            ? TransmissionType::tryFrom($filters['transmission']) 
                            : null,
            
            minPrice: $getRange('price', 0),
            maxPrice: $getRange('price', 1),
            
            minYear: $getRange('year', 0),
            maxYear: $getRange('year', 1),
            
            location: isset($filters['location']) ? new Location(
                lat: (float)($filters['location']['lat'] ?? 0),
                lng: (float)($filters['location']['lng'] ?? 0),
                radius: (int)($filters['location']['radius'] ?? 0)
            ) : null,
            
            minKilometers: $getRange('kilometers', 0),
            maxKilometers: $getRange('kilometers', 1),

            engines: isset($filters['engine']) 
                ? array_map(fn($e) => EngineType::from($e), (array)$filters['engine']) 
                : null,

            maxFuelConsumption: (int)($filters['fuel_consumption'] ?? 0),

            state: isset($filters['state']) ? 
                    StateType::tryFrom($filters['state']) 
                    : null,

            page: (int)($filters['page'] ?? 1),
            
            limit: (int)($filters['limit'] ?? 10),
        );
    }

    public function toArray(): array
    {
        $engine = array_map(fn($e) => $e->value, $this->engines ?? []);

        return array_filter([
            'brand' => is_array($this->brandIds) ? $this->brandIds[0] : null, // TODO: for now we don't support multiple brand (FE barrier) -> then just $this->brandIds
            'color' => is_array($this->colors) ? $this->colors[0] : null, // TODO: for now we don't support multiple color (FE barrier) -> then just $this->colors
            'transmission' => $this->transmission?->value,
            'price' => ['min' => $this->minPrice, 'max' => $this->maxPrice],
            'year' => ['min' => $this->minYear, 'max' => $this->maxYear],
            'location' => $this->location ? [
                'lat' => $this->location->lat,
                'lng' => $this->location->lng,
                'radius' => $this->location->radius
            ] : null,
            'km' => ['min' => $this->minKilometers, 'max' => $this->maxKilometers],
            'engine' => is_array($engine) && !empty($engine) ? $engine[0] : null, // TODO: for now we don't support multiple engine (FE barrier) -> then just $engine
            'maxFuelConsumption' => $this->maxFuelConsumption,
            'state' => $this->state?->value,
        ], fn($v) => ($v !== null  
                      && $v !== []  
                      && $v !== ''  
                      && $v !== 0  
                      && (is_array($v) && array_key_exists('min', $v) ? $v['min'] !== null : !empty($v))
                    ));
    }
}
