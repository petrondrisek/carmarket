<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Brand;
use App\Models\User;

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
    'year', 'locationLat', 'locationLng', 'user_id', 'kilometers', 'description', 'fuel_consumption', 
    'images', 'other_features', 'is_sold'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
