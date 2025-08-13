<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Support\Money;

class TotalsService {
    public function recalculate(Cart $cart): array {
        $items = $cart->items()->with('sku')->get();
        $currency = 'TRY';
        $subtotal_minor = 0; $tax_minor = 0; $discount_minor = 0; $shipping_minor = (int) (($cart->totals['shipping_minor'] ?? 0));

        foreach ($items as $it) {
            $ccy = $it->sku->currency ?: $currency;
            $currency = $ccy;
            $unit_minor = (int) ($it->price_snapshot['unit_minor'] ?? Money::toMinor($it->sku->getAttribute('price'), $ccy));
            $line_minor = $unit_minor * $it->qty;
            $subtotal_minor += $line_minor;

            $tax_bp = (int) ($it->sku->product->tax_rate_bp ?? 0);
            $tax_minor += (int) floor($line_minor * $tax_bp / 10000);
            $it->price_snapshot = [
                'unit_minor'=>$unit_minor, 'currency'=>$ccy,
                'tax_minor'=>0, 'discount_minor'=>0
            ];
            $it->save();
        }
        $grand_minor = max(0, $subtotal_minor + $tax_minor + $shipping_minor - $discount_minor);

        return [
            'currency'=>$currency,
            'subtotal_minor'=>$subtotal_minor,
            'tax_minor'=>$tax_minor,
            'discount_minor'=>$discount_minor,
            'shipping_minor'=>$shipping_minor,
            'grand_minor'=>$grand_minor,
        ];
    }
}
