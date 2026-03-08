<?php
namespace App\Types\Car;

readonly class Location
{
    public function __construct(
        public float $lat,
        public float $lng,
        public ?int $radius = null,
        public ?string $name = null
    ) {}
}