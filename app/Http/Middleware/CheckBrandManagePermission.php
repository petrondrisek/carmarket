<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;

class CheckBrandManagePermission
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!app()->make(UserService::class)->checkPermission($user, 'BRAND_MANAGE')) {
            return redirect()->route('app_dashboard')->withErrors([
                'permissions' => 'You do not have permission to manage brands',
            ]);
        }

        return $next($request);
    }
}
