<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\OrderCreated::class => [
            \App\Listeners\SendOrderConfirmation::class,
            \App\Listeners\IncreaseCouponUsage::class,
            \App\Listeners\EmitStockAlert::class,
            \App\Listeners\WriteAuditLog::class,
        ],
        \App\Events\OrderStatusUpdated::class => [
            \App\Listeners\WriteAuditLog::class,
        ],
        \App\Events\PaymentSucceeded::class => [
            \App\Listeners\RecordPayment::class,
            \App\Listeners\WriteAuditLog::class,
        ],
        \App\Events\PaymentFailed::class => [
            \App\Listeners\WriteAuditLog::class,
        ],
        \App\Events\CouponApplied::class => [
            \App\Listeners\WriteAuditLog::class,
        ],
        \App\Events\StockBelowThreshold::class => [
            \App\Listeners\WriteAuditLog::class,
        ],
    ];
}
