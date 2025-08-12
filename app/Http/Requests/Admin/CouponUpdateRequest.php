<?php

namespace App\Http\Requests\Admin;

class CouponUpdateRequest extends CouponStoreRequest {
    public function rules(): array {
        $r = parent::rules(); $r['code'] = ['required','string','max:64','unique:coupons,code,'.$this->coupon->id]; return $r;
    }
}
