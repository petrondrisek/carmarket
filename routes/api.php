<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BrandApiController;
use App\Http\Controllers\SearchMapApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Brands
Route::get('/brands', [BrandApiController::class, 'getAll']);

// Search
Route::get('/search-by-city/{alias}', [SearchMapApiController::class, 'searchByCityName']);
