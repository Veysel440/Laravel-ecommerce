<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SkuResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'id'=>$this->id,
            'code'=>$this->code,
            'price'=>$this->price,
            'compare_at_price'=>$this->compare_at_price,
            'currency'=>$this->currency,
            'inventory'=>['qty'=>$this->whenLoaded('inventory', fn()=> $this->inventory->qty ?? 0)],
            'options'=>$this->whenLoaded('optionValues', fn()=> $this->optionValues->map(fn($v)=>[
                'option'=>$v->option->name,'value'=>$v->value,
            ])),
        ];
    }
}
