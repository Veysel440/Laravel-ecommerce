<?php

namespace App\Services\Cart;

use App\Models\{Cart, CartItem, Sku};
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CartService {
    public function __construct(private TotalsService $totals) {}

    public function add(Cart $cart, int $skuId, int $qty): Cart {
        return DB::transaction(function() use($cart,$skuId,$qty) {
            /** @var Sku $sku */
            $sku = Sku::with('inventory')->lockForUpdate()->findOrFail($skuId);
            $this->assertStock($sku, $qty);

            $item = $cart->items()->firstOrCreate(['sku_id'=>$sku->id], [
                'qty'=>0,'price_snapshot'=>[
                    'unit_minor'=>$sku->price_minor,
                    'currency'=>$sku->currency,
                    'tax_minor'=>0,'discount_minor'=>0
                ],
            ]);
            $item->qty += $qty;
            $this->assertStock($sku, $item->qty);
            $item->save();

            $cart->refresh();
            $cart->totals = $this->totals->recalculate($cart);
            $cart->save();

            return $cart->load('items.sku.inventory');
        });
    }

    public function updateQty(Cart $cart, int $itemId, int $qty): Cart {
        return DB::transaction(function() use($cart,$itemId,$qty) {
            /** @var CartItem $item */
            $item = $cart->items()->lockForUpdate()->findOrFail($itemId);
            if ($qty === 0) { $item->delete(); }
            else {
                $sku = $item->sku()->with('inventory')->lockForUpdate()->first();
                $this->assertStock($sku, $qty);
                $item->qty = $qty; $item->save();
            }
            $cart->refresh();
            $cart->totals = $this->totals->recalculate($cart);
            $cart->save();
            return $cart->load('items.sku.inventory');
        });
    }

    public function remove(Cart $cart, int $itemId): Cart {
        $cart->items()->whereKey($itemId)->delete();
        $cart->refresh();
        $cart->totals = $this->totals->recalculate($cart);
        $cart->save();
        return $cart->load('items.sku.inventory');
    }

    private function assertStock(\App\Models\Sku $sku, int $desiredQty): void {
        $available = ($sku->inventory->qty ?? 0) - ($sku->inventory->reserved_qty ?? 0);
        if ($desiredQty > $available) {
            throw new \App\Exceptions\InsufficientStockException(['available'=>$available,'requested'=>$desiredQty,'sku'=>$sku->id]);
        }
    }
}
