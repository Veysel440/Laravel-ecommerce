<?php

namespace App\Services\Payment\Drivers;

use App\Services\Payment\PaymentGatewayInterface;

class NullPaymentGateway implements PaymentGatewayInterface
{
    public function createIntent(string $currency, float $amount, array $meta = []): array
    {
        return [
            'provider'=>'null',
            'reference'=>'TEST-'.uniqid(),
            'amount'=>$amount,
            'currency'=>$currency,
            'status'=>'requires_confirmation',
            'meta'=>$meta,
        ];
    }

    public function confirm(string $reference, array $meta = []): array
    {
        return [
            'provider'=>'null',
            'reference'=>$reference,
            'status'=>'succeeded',
            'meta'=>$meta,
        ];
    }
}
