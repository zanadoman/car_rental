<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response | JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Login required.'], 401);
        }
        if (!Auth::user()->active) {
            return response()->json(['error' => 'Account suspended.'], 401);
        }
        if (!in_array(Auth::user()->role, $roles, true)) {
            return response()->json(['error' => 'Insufficient role.'], 401);
        }
        return $next($request);
    }
}
