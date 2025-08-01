<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'product'    => new ProductResource($this->product),
            'quantity'   => $this->quantity,
            'price'      => $this->price,
        ];
    }
}
