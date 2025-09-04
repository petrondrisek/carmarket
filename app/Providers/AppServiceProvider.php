<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $user = auth()->user();

        // Fix storage profile photo
        if ($user && $user->profile_photo_path) {
            $user->profile_photo_path = asset('storage/' . $user->profile_photo_path);
        }

        Inertia::share([
            "auth" => $user
        ]);
    }
}
