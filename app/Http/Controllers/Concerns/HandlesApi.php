<?php

namespace App\Http\Controllers\Concerns;

trait HandlesApi {
    protected function attempt(callable $fn) {
        try { return \App\Support\ApiResponse::ok($fn()); }
        catch (\App\Exceptions\ApiException $e) { throw $e; }
        catch (\Throwable $e) { \Log::error('api.unhandled',['e'=>$e]); throw new \App\Exceptions\DomainStateException('operation_failed'); }
    }
}
