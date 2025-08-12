<?php

namespace App\Http\Requests\Admin;

class BrandUpdateRequest extends BrandStoreRequest {
    public function rules(): array {
        return ['name'=>['required','string','max:120'],
            'slug'=>['nullable','alpha_dash','max:160','unique:brands,slug,'.$this->brand->id]];
    }
}
