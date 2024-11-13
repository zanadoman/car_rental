<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Login required.'], 401);
        }
        if (!Auth::user()->active) {
            return response()->json(['error' => 'Account suspended.'], 401);
        }
        foreach (explode(',', $roles) as $role) {
            if (Auth::user()->role == $role) {
                return $next($request);
            }
        }
        return response()->json(['error' => 'Insufficient role.'], 401);
    }
}
