<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('coupons.manage'); }
    public function rules(): array {
        return [
            'code'=>['required','string','max:64','unique:coupons,code'],
            'type'=>['required','in:percent,fixed'],
            'value'=>['required','numeric','min:0'],
            'starts_at'=>['nullable','date'],
            'ends_at'=>['nullable','date','after_or_equal:starts_at'],
            'usage_limit'=>['nullable','integer','min:1'],
        ];
    }
}
