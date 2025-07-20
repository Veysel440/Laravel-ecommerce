<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Exceptions\ApiException;
class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            if ($exception instanceof ApiException) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                ], $exception->getStatusCode());
            }

            return response()->json([
                'success' => false,
                'message' => 'Beklenmeyen bir hata oluştu.',
                'error'   => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
