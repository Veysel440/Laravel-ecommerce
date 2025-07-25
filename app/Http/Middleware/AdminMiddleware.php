<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->userType !== 'admin') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return $next($request);
    }
}
