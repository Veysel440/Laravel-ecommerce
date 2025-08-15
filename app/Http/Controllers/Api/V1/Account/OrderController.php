<?php

namespace App\Http\Controllers\Api\V1\Account;


use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Support\ApiResponse;

class OrderController extends Controller
{
    public function index()
    {
        $q = auth()->user()->orders()->withCount('items')->latest();
        return ApiResponse::ok($q->paginate(20));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load(['items.sku.product','payments']);
        $items = $order->items->map(function($it){
            return [
                'sku_id'=>$it->sku_id,
                'qty'=>$it->qty,
                'unit_price'=>$it->unit_price,
                'total'=>$it->total,
                'product'=>[
                    'id'=>$it->sku->product->id,
                    'name'=>$it->sku->product->name,
                    'slug'=>$it->sku->product->slug,
                ],
            ];
        });
        return ApiResponse::ok([
            'id'=>$order->id,'number'=>$order->number,'status'=>$order->status,
            'totals'=>$order->totals,'currency'=>$order->currency,'items'=>$items,
        ]);
    }
}
