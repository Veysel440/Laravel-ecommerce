<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Monolog\LogRecord;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use App\Observers\SkuObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Services\Payment\PaymentGatewayInterface::class,
            \App\Services\Payment\NullPaymentGateway::class
        );
    }

    public function boot(): void
    {
        Log::getLogger()->pushProcessor(function (LogRecord $record): LogRecord {
            $mask = static function ($v) {
                return is_string($v) ? preg_replace('/\b(\w{2})\w+(\w{2})\b/u', '$1***$2', $v) : $v;
            };

            $ctx = $record->context;
            foreach (['email', 'phone', 'token', 'password'] as $k) {
                if (isset($ctx[$k])) {
                    $ctx[$k] = $mask($ctx[$k]);
                }
            }

            return $record->with(context: $ctx);
        });

        Product::observe(ProductObserver::class);
        Order::observe(OrderObserver::class);
        Sku::observe(SkuObserver::class);
    }
}
