<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('media.manage') ?? $this->user()?->hasRole('admin'); }
    public function rules(): array {
        return [
            'files'   => ['required','array','max:10'],
            'files.*' => ['required','file','max:'.(int) (config('media.max_bytes')/1024)],
        ];
    }
}
