<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Idempotency
{
    public function handle(Request $request, Closure $next, string $ttl='120')
    {
        $key = trim($request->header('Idempotency-Key',''));
        if ($request->isMethodSafe() || $key === '') return $next($request);

        $scope = $request->user()?->id ?: $request->ip();
        $cacheKey = "idem:{$scope}:{$request->method()}:{$request->path()}:{$key}";

        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        $response = $next($request);
        if ($response->getStatusCode() < 400) {
            Cache::put($cacheKey, $response->getData(true), now()->addSeconds((int)$ttl));
        }
        return $response;
    }
}
