<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->id > 0; }
    public function rules(): array {
        return [
            'product_id'=>['required','integer','exists:products,id'],
            'rating'=>['required','integer','min:1','max:5'],
            'body'=>['nullable','string','max:2000'],
        ];
    }
}
