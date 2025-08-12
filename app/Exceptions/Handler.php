<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\ApiException;
class Handler extends ExceptionHandler
{
    public function render($request, \Throwable $e)
    {
        if ($e instanceof \App\Exceptions\ApiException) {
            return \App\Support\ApiResponse::fail($e->getMessage(), $e->status, $e->meta);
        }
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return \App\Support\ApiResponse::fail('validation_error', 422, ['errors'=>$e->errors()]);
        }
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return \App\Support\ApiResponse::fail('unauthenticated', 401);
        }
        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return \App\Support\ApiResponse::fail('forbidden', 403);
        }
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return \App\Support\ApiResponse::fail('not_found', 404);
        }
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException) {
            return \App\Support\ApiResponse::fail('rate_limited', 429);
        }

        report($e);
        if (app()->isProduction()) {
            return \App\Support\ApiResponse::fail('server_error', 500);
        }
        return parent::render($request, $e);
    }
}
