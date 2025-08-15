<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $r = $next($request);
        $r->headers->set('X-Content-Type-Options','nosniff');
        $r->headers->set('X-Frame-Options','DENY');
        $r->headers->set('Referrer-Policy','no-referrer');
        $r->headers->set('Permissions-Policy','geolocation=(), microphone=(), camera=()');
        if (app()->isProduction() && $request->isSecure()) {
            $r->headers->set('Strict-Transport-Security','max-age=31536000; includeSubDomains; preload');
        }
        return $r;
    }
}
