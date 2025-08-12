<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'q'        => ['nullable','string','max:120'],
            'category' => ['nullable','string','max:120'],
            'brand'    => ['nullable','string','max:120'],
            'min'      => ['nullable','numeric','min:0'],
            'max'      => ['nullable','numeric','gte:min'],
            'page'     => ['nullable','integer','min:1'],
            'per_page' => ['nullable','integer','min:1','max:100'],
            'sort'     => ['nullable','in:price_asc,price_desc,newest'],
        ];
    }
}
