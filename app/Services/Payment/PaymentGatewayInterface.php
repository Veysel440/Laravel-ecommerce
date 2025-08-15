<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface {
    public function createIntent(string $currency, float $amount, array $meta = []): array;
    public function confirm(string $reference, array $meta = []): array;
    public function refund(string $reference, int $amount_minor, string $currency, array $meta = []): array;
}
