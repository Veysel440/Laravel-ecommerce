<?php

namespace App\Listeners;

use App\Events\OrderCreated;

class EmitStockAlert
{
    public function handle(OrderCreated $e): void
    {
        foreach ($e->order->items()->with('sku.inventory')->get() as $it) {
            $inv = $it->sku->inventory;
            $avail = ($inv->qty ?? 0) - ($inv->reserved_qty ?? 0);
            if ($avail < 5) {
                event(new \App\Events\StockBelowThreshold($it->sku, $avail, 5));
            }
        }
    }
}
