<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->id > 0; }
    public function rules(): array {
        return [
            'type'=>['required','in:billing,shipping'],
            'full_name'=>['required','string','max:120'],
            'phone'=>['required','string','max:30'],
            'line1'=>['required','string','max:190'],
            'line2'=>['nullable','string','max:190'],
            'city'=>['required','string','max:120'],
            'state'=>['nullable','string','max:120'],
            'postal_code'=>['required','string','max:20'],
            'country'=>['required','string','size:2'],
            'is_default'=>['boolean'],
        ];
    }
}
