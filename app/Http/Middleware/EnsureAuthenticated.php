<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $user = null;
        }

        if (!$user && !$request->routeIs('login')) {
            return Inertia::location(route('login'));
        }

        if ($user && $request->routeIs('login')) {
            return Inertia::location(route('home'));
        }

        return $next($request);
    }
}
