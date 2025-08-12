<?php

namespace App\Services\Payment;

use InvalidArgumentException;

class PaymentGatewayManager
{
    /** @var array<string, PaymentGatewayInterface> */
    private array $drivers = [];

    public function register(string $name, PaymentGatewayInterface $driver): void
    { $this->drivers[$name] = $driver; }

    public function driver(?string $name=null): PaymentGatewayInterface
    {
        $key = $name ?: config('payment.default','null');
        if (!isset($this->drivers[$key])) throw new InvalidArgumentException("payment_driver_not_found");
        return $this->drivers[$key];
    }
}
