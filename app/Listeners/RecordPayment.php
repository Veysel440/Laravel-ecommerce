<?php

namespace App\Listeners;

use App\Events\PaymentSucceeded;
use App\Models\Payment;

class RecordPayment
{
    public function handle(PaymentSucceeded $e): void
    {
        Payment::create([
            'order_id' => $e->order->id,
            'provider' => $e->provider,
            'status'   => 'captured',
            'raw_response' => ['reference'=>$e->reference],
        ]);
    }
}
