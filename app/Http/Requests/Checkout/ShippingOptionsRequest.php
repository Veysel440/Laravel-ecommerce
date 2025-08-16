<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class ShippingOptionsRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'country'=>['required','string','size:2'],
            'city'=>['nullable','string','max:120'],
            'postal_code'=>['nullable','string','max:20'],
        ];
    }
}
