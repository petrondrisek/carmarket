<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;

class CheckCarAuthorPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\Car $car */
        $car = $request->route('car');

        $user = auth()->user();

        if (
            !app()->make(UserService::class)->checkPermission($user, 'CAR_MANAGE') &&
            $car->user_id !== $user->id
        ) {
            return redirect()->route('app_dashboard')->withErrors([
                'permissions' => 'You do not have permission to manage this car offer.',
            ]);
        }

        return $next($request);
    }
}
