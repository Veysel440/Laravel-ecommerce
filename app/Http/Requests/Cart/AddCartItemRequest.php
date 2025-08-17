<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddCartItemRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'sku_id'=>['required','integer','exists:skus,id'],
            'qty'   =>['required','integer','min:1','max:999'],
        ];
    }
}
