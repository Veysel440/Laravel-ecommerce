<?php

namespace App\Services\Cart;

use App\Exceptions\InsufficientStockException;
use App\Models\Cart;
use App\Models\Sku;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(private TotalsService $totals) {}

    public function add(Cart $cart, int $skuId, int $qty): array
    {
        return DB::transaction(function() use($cart,$skuId,$qty){
            /** @var Sku $sku */
            $sku = Sku::with('inventory','product')->findOrFail($skuId);
            $available = ($sku->inventory->qty ?? 0) - ($sku->inventory->reserved_qty ?? 0);
            if ($qty < 1) $qty = 1;
            if ($qty > $available) throw new InsufficientStockException(['available'=>$available,'requested'=>$qty,'sku'=>$skuId]);

            $item = $cart->items()->firstOrCreate(['sku_id'=>$skuId], [
                'qty'=>0,'price_snapshot'=>['unit_minor'=>$sku->price_minor,'currency'=>$sku->currency,'tax_minor'=>0,'discount_minor'=>0]
            ]);
            $item->qty += $qty;
            $item->price_snapshot = [
                'unit_minor'=>$sku->price_minor,
                'currency'=>$sku->currency,
                'tax_minor'=>0,'discount_minor'=>0
            ];
            $item->save();

            $cart->refresh(); $cart->totals = $this->totals->recalculate($cart); $cart->save();
            return $this->present($cart);
        });
    }

    public function updateQty(Cart $cart, int $itemId, int $qty): array
    {
        return DB::transaction(function() use($cart,$itemId,$qty){
            $item = $cart->items()->whereKey($itemId)->with('sku.inventory','sku.product')->firstOrFail();
            if ($qty <= 0) { $item->delete(); }
            else {
                $available = ($item->sku->inventory->qty ?? 0) - ($item->sku->inventory->reserved_qty ?? 0);
                if ($qty > $available) throw new InsufficientStockException(['available'=>$available,'requested'=>$qty,'sku'=>$item->sku_id]);
                $item->qty = $qty; $item->save();
            }
            $cart->refresh(); $cart->totals = $this->totals->recalculate($cart); $cart->save();
            return $this->present($cart);
        });
    }

    public function remove(Cart $cart, int $itemId): array
    {
        $cart->items()->whereKey($itemId)->delete();
        $cart->refresh(); $cart->totals = $this->totals->recalculate($cart); $cart->save();
        return $this->present($cart);
    }

    public function present(Cart $cart): array
    {
        return [
            'id'=>$cart->id,
            'currency'=>$cart->totals['currency'] ?? 'TRY',
            'items'=>$cart->items()->with('sku.product')->get()->map(function($it){
                return [
                    'id'=>$it->id,
                    'sku_id'=>$it->sku_id,
                    'qty'=>$it->qty,
                    'unit_minor'=>(int)($it->price_snapshot['unit_minor'] ?? 0),
                    'currency'=>$it->price_snapshot['currency'] ?? 'TRY',
                    'product'=>[
                        'id'=>$it->sku->product->id,
                        'name'=>$it->sku->product->name,
                        'slug'=>$it->sku->product->slug,
                    ],
                ];
            }),
            'totals'=>$cart->totals,
        ];
    }
}
