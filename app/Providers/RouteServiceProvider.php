<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot()
    {
        $this->routes(function () {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            Route::middleware('api')
                ->prefix('api/admin')
                ->group(base_path('routes/admin.php'));
        });
    }
}
