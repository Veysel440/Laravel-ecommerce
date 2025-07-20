<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\OrderCreated;
use App\Mail\OrderCompletedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderCompletedMail
{
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        Mail::to($order->user->email)
            ->send(new OrderCompletedMail($order));
    }
}
