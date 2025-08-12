<?php

namespace App\Listeners;


use App\Events\OrderCreated;
use App\Models\Coupon;

class IncreaseCouponUsage
{
    public function handle(OrderCreated $e): void
    {
        $code = data_get($e->order->totals, 'coupon_code');
        if (!$code) return;
        $coupon = Coupon::where('code',$code)->first();
        if ($coupon) { $coupon->increment('used_count'); }
    }
}
