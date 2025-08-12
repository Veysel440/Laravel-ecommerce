<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderStatusRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('orders.manage'); }
    public function rules(): array { return ['status'=>['required','in:pending,paid,shipped,completed,cancelled,refunded']]; }
}
