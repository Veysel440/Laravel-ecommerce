<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller {
    public function __construct(){ $this->middleware('permission:catalog.manage'); }
    public function index()
    {
        return Brand::query()->latest()->paginate(20);
    }
    public function store(\App\Http\Requests\Admin\BrandStoreRequest $r){
        $slug = $r->slug ?? \Illuminate\Support\Str::slug($r->name);
        return response()->json(['success'=>true,'data'=> Brand::create(['name'=>$r->name,'slug'=>$slug])],201);
    }
    public function update(\App\Models\Brand $brand, \App\Http\Requests\Admin\BrandUpdateRequest $r){
        $brand->update($r->validated()); return ['success'=>true,'data'=>$brand];
    }
    public function destroy(\App\Models\Brand $brand){ $brand->delete(); return ['success'=>true]; }
}
