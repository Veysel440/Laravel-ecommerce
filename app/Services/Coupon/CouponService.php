<?php

namespace App\Services\Coupon;

use App\Events\CouponApplied;
use App\Exceptions\CouponException;
use App\Models\Cart;
use App\Models\Coupon;
use App\Support\Money;
use Illuminate\Support\Carbon;

class CouponService
{
    public function apply(Cart $cart, string $code): array
    {
        $c = Coupon::where('code',$code)->first();
        if (!$c) throw new CouponException('coupon_not_found');

        $now = Carbon::now();
        if (($c->starts_at && $now->lt($c->starts_at)) || ($c->ends_at && $now->gt($c->ends_at))) {
            throw new CouponException('coupon_inactive');
        }
        if ($c->usage_limit && $c->used_count >= $c->usage_limit) {
            throw new CouponException('coupon_exhausted');
        }

        $t = $cart->totals ?? [];
        $subtotal = (int) ($t['subtotal_minor'] ?? 0);
        if ($subtotal <= 0) throw new CouponException('empty_cart');

        $discount = 0;
        if ($c->type === 'percent') {
            $discount = (int) floor($subtotal * (float)$c->value / 100);
        } else {
            $discount = Money::toMinor((float)$c->value, $t['currency'] ?? 'TRY');
        }

        $t['discount_minor'] = max(0, min($discount, $subtotal));
        $t['grand_minor'] = max(0, ($t['subtotal_minor'] ?? 0) + ($t['tax_minor'] ?? 0) + ($t['shipping_minor'] ?? 0) - $t['discount_minor']);
        $t['coupon_code'] = $c->code;
        $cart->totals = $t; $cart->save();

        event(new CouponApplied($cart, $c->code));
        return $t;
    }

    public function remove(Cart $cart): array
    {
        $t = $cart->totals ?? [];
        unset($t['coupon_code']); $t['discount_minor'] = 0;
        $t['grand_minor'] = max(0, ($t['subtotal_minor'] ?? 0) + ($t['tax_minor'] ?? 0) + ($t['shipping_minor'] ?? 0));
        $cart->totals = $t; $cart->save();
        return $t;
    }
}
