<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ETagResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($request->isMethod('GET') && $response->getStatusCode() === 200 && $response->headers->get('Content-Type') === 'application/json') {
            $etag = '"' . md5($response->getContent()) . '"';
            $response->headers->set('ETag', $etag);
            if ($request->headers->get('If-None-Match') === $etag) {
                $response->setNotModified();
            }
        }
        return $response;
    }
}
