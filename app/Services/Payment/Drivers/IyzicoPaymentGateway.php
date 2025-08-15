<?php

namespace App\Services\Payment\Drivers;

use App\Services\Payment\PaymentGatewayInterface;
use App\Exceptions\PaymentFailedException;
use Throwable;

class IyzicoPaymentGateway implements PaymentGatewayInterface
{
    public function __construct(private ?string $apiKey=null, private ?string $secret=null) {
        $this->apiKey = $this->apiKey ?: config('services.iyzico.key');
        $this->secret = $this->secret ?: config('services.iyzico.secret');
    }

    public function createIntent(string $currency, float $amount, array $meta = []): array {
        try { $ref = 'iyz_'.bin2hex(random_bytes(6)); return ['provider'=>'iyzico','reference'=>$ref,'amount'=>$amount,'currency'=>$currency,'status'=>'requires_confirmation','meta'=>$meta]; }
        catch (Throwable $e) { report($e); throw new PaymentFailedException('iyzico_intent_error'); }
    }

    public function confirm(string $reference, array $meta = []): array {
        try { return ['provider'=>'iyzico','reference'=>$reference,'status'=>'succeeded','meta'=>$meta]; }
        catch (Throwable $e) { report($e); throw new PaymentFailedException('iyzico_confirm_error'); }
    }

    public function refund(string $reference, int $amount_minor, string $currency, array $meta = []): array {
        try { $r = 'iyz_r_'.bin2hex(random_bytes(6)); return ['provider'=>'iyzico','reference'=>$r,'status'=>'succeeded','amount_minor'=>$amount_minor,'currency'=>$currency,'meta'=>$meta]; }
        catch (Throwable $e) { report($e); throw new PaymentFailedException('iyzico_refund_error'); }
    }
}
