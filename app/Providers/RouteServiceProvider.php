<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('api', fn($r)=> [Limit::perMinute(60)->by($r->user()?->id ?: $r->ip())]);
        RateLimiter::for('admin', fn($r)=> [Limit::perMinute(60)->by($r->user()?->id ?: $r->ip())]);
        RateLimiter::for('auth', fn($r)=> [Limit::perMinute(20)->by($r->ip())]);
        RateLimiter::for('cart', fn($r)=> [Limit::perMinute(120)->by(($r->user()?->id ?: $r->ip()).'|'.$r->header('X-Cart-Session'))]);
        RateLimiter::for('webhooks', fn($r)=> [Limit::perMinute(120)->by($r->ip())]);
        RateLimiter::for('reviews', fn($r)=> [\Illuminate\Cache\RateLimiting\Limit::perMinute(10)->by($r->user()?->id ?: $r->ip())]);
    }
}
