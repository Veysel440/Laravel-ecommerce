<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('orders.manage') ?? false; }
    public function rules(): array {
        return [
            'amount'   => ['required','numeric','gt:0'],
            'provider' => ['nullable','in:null,stripe,iyzico'],
        ];
    }
}
