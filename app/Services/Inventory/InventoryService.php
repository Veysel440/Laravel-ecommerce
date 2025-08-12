<?php

namespace App\Services\Inventory;

use App\Models\{Cart, Sku};
use Illuminate\Support\Facades\DB;
use RuntimeException;use App\Exceptions\DomainStateException;

class InventoryService {
    public function reserveFromCart(\App\Models\Cart $cart): void {
        \DB::transaction(function() use($cart){
            foreach ($cart->items()->with('sku.inventory')->lockForUpdate()->get() as $item) {
                $inv = $item->sku->inventory;
                $available = $inv->qty - $inv->reserved_qty;
                if ($item->qty > $available) throw new DomainStateException('stock_changed', ['sku'=>$item->sku_id,'available'=>$available]);
                $inv->reserved_qty += $item->qty; $inv->save();
            }
        });
    }

    public function commitFromCart(Cart $cart): void {
        DB::transaction(function() use($cart){
            foreach ($cart->items()->with('sku.inventory')->lockForUpdate()->get() as $item) {
                $inv = $item->sku->inventory;
                $inv->reserved_qty -= $item->qty;
                $inv->qty -= $item->qty;
                if ($inv->reserved_qty < 0 || $inv->qty < 0) throw new RuntimeException('Inventory negative');
                $inv->save();
            }
        });
    }

    public function releaseFromCart(Cart $cart): void {
        DB::transaction(function() use($cart){
            foreach ($cart->items()->with('sku.inventory')->lockForUpdate()->get() as $item) {
                $inv = $item->sku->inventory;
                $inv->reserved_qty -= $item->qty;
                if ($inv->reserved_qty < 0) $inv->reserved_qty = 0;
                $inv->save();
            }
        });
    }
}
