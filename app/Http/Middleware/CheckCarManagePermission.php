<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;

class CheckCarManagePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!app()->make(UserService::class)->checkPermission($user, 'CAR_MANAGE')) {
            return redirect()->route('app_dashboard')->withErrors([
                'permissions' => 'You do not have permission to manage cars',
            ]);
        }

        return $next($request);
    }
}
