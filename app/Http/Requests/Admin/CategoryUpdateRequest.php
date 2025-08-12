<?php

namespace App\Http\Requests\Admin;

class CategoryUpdateRequest extends CategoryStoreRequest {
    public function rules(): array {
        return [
            'parent_id'=>['nullable','exists:categories,id'],
            'name'=>['required','string','max:120'],
            'slug'=>['nullable','alpha_dash','max:160','unique:categories,slug,'.$this->category->id],
            'status'=>['required','in:active,inactive'],
        ];
    }
}
