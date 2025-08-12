<?php

namespace App\Http\Requests\Admin;

class ProductUpdateRequest extends ProductStoreRequest {
    public function rules(): array {
        $r = parent::rules();
        $r['slug'] = ['nullable','alpha_dash','max:190','unique:products,slug,'.$this->product->id];
        $r['skus.*.code'] = ['required','string','max:120','unique:skus,code,{{sku_id}}'];
        return $r;
    }
}
