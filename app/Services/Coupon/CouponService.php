<?php

namespace App\Services\Coupon;

use App\Models\{Cart,Coupon};
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use App\Exceptions\CouponException;

class CouponService {
    public function apply(Cart $cart, string $code): array {
        $c = \App\Models\Coupon::where('code',$code)->first();
        if (!$c) throw new CouponException('coupon_not_found');
        $now = Carbon::now();
        if (($c->starts_at && $now->lt($c->starts_at)) || ($c->ends_at && $now->gt($c->ends_at))) {
            throw new CouponException('coupon_inactive');
        }
        if ($c->usage_limit && $c->used_count >= $c->usage_limit) {
            throw new CouponException('coupon_exhausted');
        }
        $totals = $cart->totals ?? ['subtotal'=>0,'grand'=>0];
        $discount = $c->type === 'percent'
            ? round(($totals['subtotal'] ?? 0) * ((float)$c->value/100), 2)
            : min((float)$c->value, (float)($totals['subtotal'] ?? 0));
        $totals['discount'] = $discount;
        $totals['grand'] = max(0, ($totals['subtotal'] ?? 0) - $discount + ($totals['taxTotal'] ?? 0));
        $cart->totals = $totals;
        $cart->save();
        return ['coupon'=>$c->only(['code','type','value']),'totals'=>$totals];
    }

    public function remove(Cart $cart): array {
        if (!$cart->totals) return ['totals'=>null];
        $t = $cart->totals; $t['discount']=0;
        $t['grand'] = ($t['subtotal'] ?? 0) + ($t['taxTotal'] ?? 0);
        $cart->totals = $t; $cart->save();
        return ['totals'=>$t];
    }
}
