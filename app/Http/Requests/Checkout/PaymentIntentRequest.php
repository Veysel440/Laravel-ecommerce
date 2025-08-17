<?php

namespace App\Http\Requests\Checkout;


use Illuminate\Foundation\Http\FormRequest;

class PaymentIntentRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'provider'=>['nullable','in:null,stripe,iyzico'],
        ];
    }
}
