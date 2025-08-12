<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReviewModerateRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->can('reviews.moderate'); }
    public function rules(): array { return ['status'=>['required','in:approved,rejected']]; }
}
