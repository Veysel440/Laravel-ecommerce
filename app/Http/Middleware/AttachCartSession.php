<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttachCartSession
{
    public function handle(Request $request, Closure $next)
    {
        $sid = $request->header('X-Cart-Session') ?: $request->cookie('cart_session');
        if (!$sid) { $sid = (string) Str::uuid(); }
        app()->instance('cart_session', $sid);
        $response = $next($request);
        $response->headers->set('X-Cart-Session', $sid);
        cookie()->queue(cookie('cart_session', $sid, 60 * 24 * 7, httpOnly: false, secure: false, sameSite: 'lax'));
        return $response;
    }
}
