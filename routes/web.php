<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Middleware\CheckBrandManagePermission;
use App\Http\Middleware\CheckCarManagePermission;
use App\Http\Middleware\CheckCarAuthorPermission;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchMapController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;

// Main
Route::get('/', [DashboardController::class, 'index'])->name('app_dashboard');

// Search
Route::get('/search', [SearchMapController::class, 'index'])->name('app_search');

// Brand
Route::middleware([
    CheckBrandManagePermission::class, 
    'auth',
])->group(function () {
    Route::get('/brand/add', [BrandController::class, 'add'])->name('app_brand_add');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('app_brand_store');
    Route::get('/brand/manage', [BrandController::class, 'list'])->name('app_brand_manage');
    Route::get('/brand/edit/{brand}', [BrandController::class, 'edit'])->name('app_brand_edit');
    Route::post('/brand/edit/{brand}', [BrandController::class, 'update'])->name('app_brand_save');
    Route::delete('/brand/delete/{brand}', [BrandController::class, 'destroy'])->name('app_brand_delete');
});

// Car
Route::get('/car/add', [CarController::class, 'add'])->name('app_car_add');
Route::get('/car/list', [CarController::class, 'list'])->name('app_car_get');
Route::get('/car/show/{carId}', [CarController::class, 'show'])->name('app_car_show');
Route::post('/car/store', [CarController::class, 'store'])->name('app_car_store')->middleware('auth');

Route::middleware([
    CheckCarManagePermission::class, 
    'auth',
])->group(function () {
    Route::get('/car/edit/{carId}', [CarController::class, 'edit'])->name('app_car_edit');
    Route::post('/car/edit/{car}', [CarController::class, 'update'])->name('app_car_save');
    Route::delete('/car/delete/{car}', [CarController::class, 'destroy'])->name('app_car_delete');
});

Route::middleware([
    CheckCarAuthorPermission::class,
    'auth',
])->group(function () {
    Route::post('/car/sold/{car}', [CarController::class, 'sold'])->name('app_car_sold');
});