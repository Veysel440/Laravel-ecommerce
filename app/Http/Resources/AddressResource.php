<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'full_name'=>$this->full_name,
            'phone'=>$this->phone,
            'line1'=>$this->line1 ?? null,
            'line2'=>$this->line2 ?? null,
            'city'=>$this->city,
            'state'=>$this->state,
            'postal_code'=>$this->postal_code,
            'country'=>$this->country,
            'is_default'=>$this->is_default,
        ];
    }
}
