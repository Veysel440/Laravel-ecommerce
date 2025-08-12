<?php

namespace App\Services\Payment\Drivers;

use App\Services\Payment\PaymentGatewayInterface;
use App\Exceptions\PaymentFailedException;
use Throwable;

class StripePaymentGateway implements PaymentGatewayInterface
{
    public function __construct(
        private ?string $secret = null
    ) {
        $this->secret = $this->secret ?: config('services.stripe.secret');
    }

    public function createIntent(string $currency, float $amount, array $meta = []): array
    {
        try {
            $ref = 'pi_'.bin2hex(random_bytes(6));
            return ['provider'=>'stripe','reference'=>$ref,'amount'=>$amount,'currency'=>$currency,'status'=>'requires_confirmation','meta'=>$meta];
        } catch (Throwable $e) {
            report($e);
            throw new PaymentFailedException('stripe_intent_error');
        }
    }

    public function confirm(string $reference, array $meta = []): array
    {
        try {
            return ['provider'=>'stripe','reference'=>$reference,'status'=>'succeeded','meta'=>$meta];
        } catch (Throwable $e) {
            report($e);
            throw new PaymentFailedException('stripe_confirm_error');
        }
    }
}
