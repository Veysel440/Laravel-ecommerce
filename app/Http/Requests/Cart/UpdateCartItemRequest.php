<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array { return ['qty'=>['required','integer','min:0','max:999']]; }
}
