<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandImage extends Model
{
    protected $fillable = ['image_id', 'brand_id'];

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
