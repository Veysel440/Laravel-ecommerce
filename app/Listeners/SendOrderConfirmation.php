<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmation
{
    public function handle(OrderCreated $e): void
    {
        if ($e->order->user?->email) {
            Mail::to($e->order->user->email)->queue(new OrderConfirmationMail($e->order));
        }
    }
}
