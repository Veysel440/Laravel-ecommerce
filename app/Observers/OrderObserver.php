<?php

namespace App\Observers;

use App\Events\OrderStatusUpdated;
use App\Models\Order;

class OrderObserver
{
    public function updating(Order $order): void
    {
        if ($order->isDirty('status')) {
            $old = $order->getOriginal('status');
            $new = $order->status;
            event(new OrderStatusUpdated($order, $old, $new));
        }
    }
}
