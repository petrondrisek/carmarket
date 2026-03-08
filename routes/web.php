<?php
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Brand\CheckBrandManagePermission;
use App\Http\Middleware\Car\CheckCarManagePermission;
use App\Http\Middleware\Car\CheckCarAuthorPermission;

// Main
Route::get(
    '/',
    \App\Http\Controllers\Dashboard\InertiaDashboardController::class
)->name('app_dashboard');

// Brand
Route::middleware([
    CheckBrandManagePermission::class, 
    'auth',
])->group(function () {
    Route::get(
        '/brand/add', 
        \App\Http\Controllers\Brand\InertiaAddBrandController::class
    )->name('app_brand_add');

    Route::post(
        '/brand/store',
        \App\Http\Controllers\Brand\RegisterBrandController::class
    )->name('app_brand_store');

    Route::get(
        '/brand/manage',
        \App\Http\Controllers\Brand\InertiaManageBrandsController::class
    )->name('app_brand_manage');

    Route::get(
        '/brand/edit/{brand}', 
        \App\Http\Controllers\Brand\InertiaEditBrandController::class
    )->name('app_brand_edit');

    Route::post(
        '/brand/edit/{brand}', 
        \App\Http\Controllers\Brand\UpdateBrandController::class
    )->name('app_brand_save');

    Route::delete(
        '/brand/delete/{brand}', 
        \App\Http\Controllers\Brand\DeleteBrandController::class
    )->name('app_brand_delete');
});

// Car
Route::get(
    '/car/add',
    \App\Http\Controllers\Car\InertiaAddCarController::class
)->name('app_car_add');

Route::get(
    '/car/list', 
    \App\Http\Controllers\Car\InertiaFilterCarController::class
)->name('app_car_get');

Route::get(
    '/car/show/{car}', 
    \App\Http\Controllers\Car\InertiaShowCarController::class
)->name('app_car_show');

Route::post(
    '/car/store', 
    \App\Http\Controllers\Car\RegisterCarController::class
)->name('app_car_store')->middleware('auth');

Route::get(
    '/car/search',
    \App\Http\Controllers\Car\InertiaSearchCarController::class
)->name('app_car_search');

Route::middleware([
    CheckCarManagePermission::class, 
    'auth',
])->group(function () {
    Route::get(
        '/car/edit/{car}', 
        \App\Http\Controllers\Car\InertiaEditCarController::class
    )->name('app_car_edit');

    Route::post(
        '/car/edit/{car}', 
        \App\Http\Controllers\Car\UpdateCarController::class
    )->name('app_car_save');

    Route::delete(
        '/car/delete/{car}', 
        \App\Http\Controllers\Car\DeleteCarController::class
    )->name('app_car_delete');
});

Route::middleware([
    CheckCarAuthorPermission::class,
    'auth',
])->group(function () {
    Route::post(
        '/car/sold/{car}', 
        \App\Http\Controllers\Car\MarkAsSoldCarController::class
    )->name('app_car_sold');
});