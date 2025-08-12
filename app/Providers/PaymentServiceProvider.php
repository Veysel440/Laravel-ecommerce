<?php

namespace App\Providers;

use App\Services\Payment\Drivers\IyzicoPaymentGateway;
use App\Services\Payment\Drivers\NullPaymentGateway;
use App\Services\Payment\Drivers\StripePaymentGateway;
use App\Services\Payment\PaymentGatewayManager;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentGatewayManager::class, function(){
            $m = new PaymentGatewayManager();
            $m->register('null',   new NullPaymentGateway());
            $m->register('stripe', new StripePaymentGateway());
            $m->register('iyzico', new IyzicoPaymentGateway());
            return $m;
        });
    }
}
