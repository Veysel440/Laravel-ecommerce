<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutShippingRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { return ['carrier'=>['required','in:ups,yurtici,aras,ptt'],'price'=>['required','numeric','min:0']]; }
}
