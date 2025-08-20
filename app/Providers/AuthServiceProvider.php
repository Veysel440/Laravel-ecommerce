<?php

namespace App\Providers;

use App\Models\Media;
use App\Models\Order;
use App\Models\Review;
use App\Policies\MediaPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class  => OrderPolicy::class,
        Review::class => ReviewPolicy::class,
        Media::class => MediaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(fn($user,$ability)=> $user->hasRole('admin') ? true : null);
    }
}
