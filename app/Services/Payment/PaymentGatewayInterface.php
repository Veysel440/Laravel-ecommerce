<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface {
    public function createIntent(string $currency, float $amount, array $meta = []): array;
    public function confirm(string $reference, array $meta = []): array;
}
