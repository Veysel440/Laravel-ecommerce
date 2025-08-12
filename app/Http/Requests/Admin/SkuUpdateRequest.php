<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SkuUpdateRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('catalog.manage'); }
    public function rules(): array {
        return [
            'price'=>['nullable','numeric','min:0'],
            'compare_at_price'=>['nullable','numeric','min:0'],
            'currency'=>['nullable','string','size:3'],
            'weight'=>['nullable','numeric','min:0'],
            'dimensions'=>['nullable','array'],
            'inventory_qty'=>['nullable','integer','min:0'],
        ];
    }
}
