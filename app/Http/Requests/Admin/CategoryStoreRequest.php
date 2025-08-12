<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('catalog.manage'); }
    public function rules(): array {
        return [
            'parent_id'=>['nullable','exists:categories,id'],
            'name'=>['required','string','max:120'],
            'slug'=>['nullable','alpha_dash','max:160','unique:categories,slug'],
            'status'=>['required','in:active,inactive'],
        ];
    }
}
