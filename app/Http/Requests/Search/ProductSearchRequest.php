<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'q'        => ['nullable','string','max:120'],
            'brand_id' => ['nullable','integer'],
            'categories'=> ['array'],
            'categories.*'=> ['string','max:160'],
            'price_min' => ['nullable','numeric','min:0'],
            'price_max' => ['nullable','numeric','gte:price_min'],
            'sort'     => ['nullable','in:relevance,price_asc,price_desc,newest'],
            'page'     => ['nullable','integer','min:1','max:1000'],
            'per_page' => ['nullable','integer','min:1','max:50'],
        ];
    }
}
