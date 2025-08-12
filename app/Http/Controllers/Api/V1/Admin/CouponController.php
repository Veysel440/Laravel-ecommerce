<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class CouponController extends Controller {
    public function __construct()
    {
        $this->middleware('permission:coupons.manage');
    }
    public function index()
    {
        return \App\Models\Coupon::query()->latest()->paginate(20);
    }
    public function store(\App\Http\Requests\Admin\CouponStoreRequest $r)
    {
        $c = \App\Models\Coupon::create($r->validated()); return response()->json(['success'=>true,'data'=>$c],201);
    }
    public function update(\App\Models\Coupon $coupon, \App\Http\Requests\Admin\CouponUpdateRequest $r)
    {
        $coupon->update($r->validated()); return ['success'=>true,'data'=>$coupon];
    }
    public function destroy(\App\Models\Coupon $coupon)
    {
        $coupon->delete(); return ['success'=>true];
    }
}
