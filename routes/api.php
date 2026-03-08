<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Brands
Route::get(
    '/brands',
    \App\Http\Controllers\Brand\GetBrandsController::class
)->name('api_brands_get');

// Search
Route::get(
    '/search/city', 
    \App\Http\Controllers\Search\GetCityController::class
)->name('api_search_city');
