<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->id > 0; }
    public function rules(): array {
        return [
            'rating'=>['nullable','integer','min:1','max:5'],
            'body'=>['nullable','string','max:2000'],
        ];
    }
}
