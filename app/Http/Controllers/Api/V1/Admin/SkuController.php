<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class SkuController extends Controller {
    public function __construct()
    {
        $this->middleware('permission:catalog.manage');
    }
    public function store(\App\Models\Product $product, \App\Http\Requests\Admin\SkuUpdateRequest $r)
    {
        $s = $product->skus()->create($r->validated());
        if ($r->filled('inventory_qty')) $s->inventory()->create(['qty'=>$r->inventory_qty,'reserved_qty'=>0]);
        return response()->json(['success'=>true,'data'=>$s->load('inventory')],201);
    }
    public function update(\App\Models\Sku $sku, \App\Http\Requests\Admin\SkuUpdateRequest $r)
    {
        $sku->update($r->validated());
        if ($r->filled('inventory_qty')) { $inv = $sku->inventory()->firstOrCreate([]); $inv->qty = $r->inventory_qty; $inv->save(); }
        return ['success'=>true,'data'=>$sku->load('inventory')];
    }
    public function destroy(\App\Models\Sku $sku)
    {
        $sku->delete(); return ['success'=>true];
    }
}
