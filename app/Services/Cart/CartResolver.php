<?php

namespace App\Services\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartResolver
{
    public function resolve(Request $r): Cart
    {
        $sid = app('cart_session');
        /** @var Cart $cart */
        $cart = Cart::with(['items.sku.product','items.sku.inventory'])
            ->firstOrCreate(['session_id'=>$sid], [
                'user_id'=>$r->user()?->id,
                'currency'=> 'TRY',
                'totals'  => ['currency'=>'TRY','subtotal_minor'=>0,'tax_minor'=>0,'shipping_minor'=>0,'discount_minor'=>0,'grand_minor'=>0],
            ]);

        if ($r->user() && !$cart->user_id) {
            $cart->user_id = $r->user()->id; $cart->save();
        }
        return $cart->fresh(['items.sku.product','items.sku.inventory']);
    }
}
