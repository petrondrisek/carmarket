<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Types\Car\Location;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cars';

    protected $fillable = ['brand_id', 'model', 'color', 'transmission', 'state', 'engine', 'price', 
    'year', 'location_lat', 'location_lng', 'user_id', 'kilometers', 'description', 'fuel_consumption', 
    'images', 'other_features', 'is_sold'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getClosestCityAttribute()
    {
        return City::query()
            ->select('name', 'state')
            ->selectRaw(
                "(6371 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat)))) AS distance",
                [$this->location_lat, $this->location_lng, $this->location_lat]
            )
            ->orderBy('distance')
            ->first()?->name;
    }

    public function scopeWhereInRadius($query, Location $location)
    {
        $latRadius = $location->radius / 111.32;
        $lngRadius = $location->radius / (111.32 * cos(deg2rad($location->lat)));

        return $query->whereBetween('location_lat', [$location->lat - $latRadius, $location->lat + $latRadius])
                     ->whereBetween('location_lng', [$location->lng - $lngRadius, $location->lng + $lngRadius]);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }
}
