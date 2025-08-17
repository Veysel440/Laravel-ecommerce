<?php

namespace App\Services\Inventory;

use App\Exceptions\DomainStateException;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function reserveFromCart(Cart $cart): void
    {
        DB::transaction(function() use($cart){
            foreach ($cart->items()->with('sku.inventory')->lockForUpdate()->get() as $item) {
                $inv = $item->sku->inventory;
                $available = $inv->qty - $inv->reserved_qty;
                if ($item->qty > $available) {
                    throw new DomainStateException('stock_changed', ['sku'=>$item->sku_id,'available'=>$available]);
                }
                $inv->reserved_qty += $item->qty; $inv->save();
            }
        }, 3);
    }

    public function releaseFromCart(Cart $cart): void
    {
        DB::transaction(function() use($cart){
            foreach ($cart->items()->with('sku.inventory')->lockForUpdate()->get() as $item) {
                $inv = $item->sku->inventory;
                $inv->reserved_qty = max(0, $inv->reserved_qty - $item->qty); $inv->save();
            }
        }, 3);
    }

    public function commitFromCart(Cart $cart): void
    {
        DB::transaction(function() use($cart){
            foreach ($cart->items()->with('sku.inventory')->lockForUpdate()->get() as $item) {
                $inv = $item->sku->inventory;
                $inv->qty = max(0, $inv->qty - $item->qty);
                $inv->reserved_qty = max(0, $inv->reserved_qty - $item->qty);
                $inv->save();
            }
        }, 3);
    }
}
