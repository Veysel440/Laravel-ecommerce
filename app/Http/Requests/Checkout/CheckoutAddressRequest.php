<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutAddressRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'billing'=>['required','array'],
            'shipping'=>['required','array'],
            'billing.full_name'=>['required','string','max:120'],
            'billing.phone'=>['required','string','max:30'],
            'billing.line1'=>['required','string','max:190'],
            'billing.city'=>['required','string','max:120'],
            'billing.postal_code'=>['required','string','max:20'],
            'billing.country'=>['required','string','size:2'],
            'shipping.full_name'=>['required','string','max:120'],
            'shipping.phone'=>['required','string','max:30'],
            'shipping.line1'=>['required','string','max:190'],
            'shipping.city'=>['required','string','max:120'],
            'shipping.postal_code'=>['required','string','max:20'],
            'shipping.country'=>['required','string','size:2'],
        ];
    }
}
