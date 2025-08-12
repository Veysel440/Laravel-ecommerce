<?php

namespace App\Services\Cart;

use App\Models\Cart;

class TotalsService {
    public function recalculate(Cart $cart): array {
        $items = $cart->items()->with('sku')->get();
        $currency = 'TRY';
        $subtotal = 0; $taxTotal = 0; $discount = 0;

        foreach ($items as $it) {
            $unit = (float)($it->price_snapshot['unit'] ?? $it->sku->price);
            $line = $unit * $it->qty;
            $subtotal += $line;
        }
        $grand = $subtotal + $taxTotal - $discount;
        return compact('currency','subtotal','taxTotal','discount','grand');
    }
}
