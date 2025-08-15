<?php

namespace App\Services\Payment;

use App\Events\PaymentRefunded;
use App\Exceptions\DomainStateException;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use App\Support\Money;
use Illuminate\Support\Facades\DB;

class RefundService
{
    public function __construct(private PaymentGatewayManager $gateways) {}

    public function refund(Order $order, int $amount_minor, ?Payment $payment=null, ?string $provider=null): Refund
    {
        if (!in_array($order->status, ['paid','shipped','completed'])) {
            throw new DomainStateException('order_not_refundable');
        }
        $payment = $payment ?: $order->payments()->latest()->first();
        if (!$payment) throw new DomainStateException('payment_not_found');

        $provider = $provider ?: $payment->provider;
        $driver = $this->gateways->driver($provider);

        $res = $driver->refund($payment->reference, $amount_minor, $order->currency, ['order_id'=>$order->id,'payment_id'=>$payment->id]);

        return DB::transaction(function() use($order,$payment,$amount_minor,$res,$provider){
            $refund = Refund::create([
                'order_id'=>$order->id,
                'payment_id'=>$payment->id,
                'provider'=>$provider,
                'reference'=>$res['reference'] ?? ('r_'.uniqid()),
                'amount_minor'=>$amount_minor,
                'currency'=>$order->currency,
                'status'=>$res['status'] ?? 'succeeded',
                'raw'=>$res,
            ]);

            if ($refund->status === 'succeeded') {
                $payment->status = 'refunded'; $payment->save();
                $order->status = 'refunded'; $order->save();
                event(new PaymentRefunded($order, $amount_minor, $provider, $refund->reference));
            }

            return $refund->fresh();
        });
    }
}
