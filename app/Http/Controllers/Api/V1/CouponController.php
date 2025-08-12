<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\Request;

class CouponController extends Controller {
    public function __construct(private \App\Services\Cart\CartResolver $resolver,
                                private \App\Services\Coupon\CouponService $svc) {}

    public function apply(\App\Http\Requests\Coupon\ApplyCouponRequest $req) {
        try {
            $cart = $this->resolver->resolve($req);
            $data = $this->svc->apply($cart, $req->code);
            return \App\Support\ApiResponse::ok($data);
        } catch (\App\Exceptions\ApiException $e) { throw $e; }
        catch (\Throwable $e) { \Log::warning('coupon.apply.failed',['e'=>$e]); throw new \App\Exceptions\CouponException('coupon_apply_failed'); }
    }
    public function remove(Request $req)
    {
        $cart = $this->resolver->resolve($req);
        $data = $this->svc->remove($cart);
        return response()->json(['success'=>true,'data'=>$data]);
    }
}
