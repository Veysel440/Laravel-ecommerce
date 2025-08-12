<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutConfirmRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'payment_reference'=>['required','string','max:191'],
            'provider'=>['nullable','in:null,stripe,iyzico,paypal'],
            'billing'=>['nullable','array'],
            'shipping'=>['nullable','array'],
        ];
    }
}
