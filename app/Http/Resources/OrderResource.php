<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'total_price'  => $this->total_price,
            'status'       => $this->status,
            'items'        => OrderItemResource::collection($this->items),
            'created_at'   => $this->created_at,
        ];
    }
}
