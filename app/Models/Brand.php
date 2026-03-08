<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\BrandFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';

    protected $fillable = ['name', 'logo', 'description', 'is_active'];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(BrandImage::class);
    }
}
