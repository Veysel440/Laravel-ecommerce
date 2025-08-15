<?php

namespace App\Services\Payment\Drivers;

use App\Services\Payment\PaymentGatewayInterface;

class NullPaymentGateway implements PaymentGatewayInterface
{
    public function createIntent(string $currency, float $amount, array $meta = []): array {
        return ['provider'=>'null','reference'=>'TEST-'.uniqid(),'amount'=>$amount,'currency'=>$currency,'status'=>'requires_confirmation','meta'=>$meta];
    }
    public function confirm(string $reference, array $meta = []): array {
        return ['provider'=>'null','reference'=>$reference,'status'=>'succeeded','meta'=>$meta];
    }
    public function refund(string $reference, int $amount_minor, string $currency, array $meta = []): array {
        return ['provider'=>'null','reference'=>'RFD-'.uniqid(),'status'=>'succeeded','amount_minor'=>$amount_minor,'currency'=>$currency,'meta'=>$meta];
    }
}
