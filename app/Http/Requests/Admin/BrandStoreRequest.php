<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('catalog.manage'); }
    public function rules(): array { return ['name'=>['required','string','max:120'],'slug'=>['nullable','alpha_dash','max:160','unique:brands,slug']]; }
}
