<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class OrderController extends Controller {
    public function __construct()
    {
        $this->middleware('permission:orders.view')->only(['index','show']);
        $this->middleware('permission:orders.manage')->only('updateStatus');
    }
    public function index(){
        $q = \App\Models\Order::query()->withCount('items')->latest();
        if ($s = request('status')) $q->where('status',$s);
        if ($n = request('number')) $q->where('number','like',"%$n%");
        return $q->paginate(20);
    }
    public function show(\App\Models\Order $order)
    {
        return $order->load(['items.sku.product','payments']);
    }
    public function updateStatus(\App\Models\Order $order, \App\Http\Requests\Admin\OrderStatusRequest $r)
    {
        $order->update(['status'=>$r->status]); return ['success'=>true,'data'=>$order];
    }
}
