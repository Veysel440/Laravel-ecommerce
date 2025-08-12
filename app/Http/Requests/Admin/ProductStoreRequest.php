<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('catalog.manage'); }
    public function rules(): array {
        return [
            'brand_id' => ['nullable','exists:brands,id'],
            'name'     => ['required','string','max:190'],
            'slug'     => ['nullable','alpha_dash','max:190','unique:products,slug'],
            'description' => ['nullable','string'],
            'status'   => ['required','in:draft,active,archived'],
            'tax_rate' => ['required','numeric','min:0','max:100'],
            'category_ids' => ['array'], 'category_ids.*'=>['integer','exists:categories,id'],

            'images'   => ['array'], 'images.*.path'=>['required','string','max:255'], 'images.*.sort'=>['integer','min:0'],

            'options'  => ['array'],
            'options.*.name'=>['required','string','max:60'],
            'options.*.values'=>['array','min:1'], 'options.*.values.*'=>['string','max:60'],

            'skus'     => ['array','min:1'], // [{code,price,currency,weight?,dimensions?,option_values:{Color:"Red"},inventory_qty}]
            'skus.*.code'=>['required','string','max:120','unique:skus,code'],
            'skus.*.price'=>['required','numeric','min:0'],
            'skus.*.currency'=>['required','string','size:3'],
            'skus.*.inventory_qty'=>['required','integer','min:0'],
            'skus.*.option_values'=>['array'],
        ];
    }
}
