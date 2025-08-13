<?php

namespace App\Services\Order;

use App\Models\{Cart, Order, OrderItem};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Support\Money;
class OrderService {

    public function createFromCart(Cart $cart, array $billing, array $shipping): \App\Models\Order {
        return \DB::transaction(function() use($cart,$billing,$shipping){
            $order = \App\Models\Order::create([
                'user_id'=>$cart->user_id,
                'number'=>$this->generateNumber(),
                'status'=>'pending',
                'currency'=>$cart->currency ?? ($cart->totals['currency'] ?? 'TRY'),
                'totals'=>$cart->totals ?? [],
                'billing_address'=>$billing, 'shipping_address'=>$shipping,
            ]);
            foreach ($cart->items()->with('sku.product')->get() as $it) {
                $ccy = $it->sku->currency ?? $order->currency;
                $unit_minor = (int) ($it->price_snapshot['unit_minor'] ?? Money::toMinor($it->sku->getAttribute('price'), $ccy));
                $line_minor = $unit_minor * $it->qty;
                $tax_bp = (int) ($it->sku->product->tax_rate_bp ?? 0);
                $tax_minor = (int) floor($line_minor * $tax_bp / 10000);
                \App\Models\OrderItem::create([
                    'order_id'=>$order->id,'sku_id'=>$it->sku_id,'qty'=>$it->qty,
                    'unit_price_minor'=>$unit_minor,'tax_minor'=>$tax_minor,'total_minor'=>$line_minor + $tax_minor,
                ]);
            }
            return $order->load('items');
        });
    }

    private function generateNumber(): string {
        return 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
    }
}
