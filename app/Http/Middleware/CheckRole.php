<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->role != $role) {
            // If user is not logged in or doesn't have the right role,
            // return a 403 Forbidden response.
            return response()->json(['message' => 'Access denied', 'role_needed' => $role], 403);
        }

        return $next($request);
    }
}