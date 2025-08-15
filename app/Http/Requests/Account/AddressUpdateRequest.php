<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->id > 0; }
    public function rules(): array {
        return [
            'type'=>['nullable','in:billing,shipping'],
            'full_name'=>['nullable','string','max:120'],
            'phone'=>['nullable','string','max:30'],
            'line1'=>['nullable','string','max:190'],
            'line2'=>['nullable','string','max:190'],
            'city'=>['nullable','string','max:120'],
            'state'=>['nullable','string','max:120'],
            'postal_code'=>['nullable','string','max:20'],
            'country'=>['nullable','string','size:2'],
            'is_default'=>['boolean'],
        ];
    }
}
