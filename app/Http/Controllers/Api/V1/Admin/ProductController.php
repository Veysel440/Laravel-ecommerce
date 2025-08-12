<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class ProductController extends Controller {
    public function __construct(private \App\Services\Admin\ProductAdminService $svc)
    {
        $this->middleware('permission:catalog.manage');
    }
    public function index()
    {
        $q = \App\Models\Product::query()->with(['brand','categories','images'])->latest();
        if ($s = request('q')) $q->whereFullText(['name','description'],$s);
        return \App\Http\Resources\ProductResource::collection($q->paginate(20))->additional(['success'=>true]);
    }
    public function store(\App\Http\Requests\Admin\ProductStoreRequest $r)
    {
        $p = $this->svc->create($r->validated());
        return response()->json(['success'=>true,'data'=> new \App\Http\Resources\ProductResource($p)],201);
    }
    public function show(\App\Models\Product $product)
    {
        $product->load(['brand','categories','images','skus.inventory','options.values']);
        return ['success'=>true,'data'=> new \App\Http\Resources\ProductResource($product)];
    }
    public function update(\App\Models\Product $product, \App\Http\Requests\Admin\ProductUpdateRequest $r)
    {
        $p = $this->svc->update($product, $r->validated());
        return ['success'=>true,'data'=> new \App\Http\Resources\ProductResource($p)];
    }
    public function destroy(\App\Models\Product $product)
    {
        $product->delete(); return ['success'=>true];
    }
}
