<?php

namespace App\Http\Middleware\Brand;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBrandManagePermission
{

    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user->hasPermission('BRAND_MANAGE')) {
            return redirect()->route('app_dashboard')->withErrors([
                'permissions' => 'You do not have permission to manage brands',
            ]);
        }

        return $next($request);
    }
}
