<?php

namespace App\Services\Order;

use App\Models\{Cart, Order, OrderItem};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService {
    public function createFromCart(Cart $cart, array $billing, array $shipping): Order {
        return DB::transaction(function() use($cart,$billing,$shipping){
            $number = $this->generateNumber();
            $order = Order::create([
                'user_id'=>$cart->user_id,
                'number'=>$number,
                'status'=>'pending',
                'currency'=>$cart->currency,
                'totals'=>$cart->totals ?? [],
                'billing_address'=>$billing,
                'shipping_address'=>$shipping,
            ]);
            foreach ($cart->items()->with('sku')->get() as $it) {
                OrderItem::create([
                    'order_id'=>$order->id,
                    'sku_id'=>$it->sku_id,
                    'qty'=>$it->qty,
                    'unit_price'=>$it->price_snapshot['unit'] ?? $it->sku->price,
                    'tax'=>0,
                    'total'=>($it->price_snapshot['unit'] ?? $it->sku->price) * $it->qty,
                ]);
            }
            return $order->load('items');
        });
    }

    private function generateNumber(): string {
        return 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
    }
}
