<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'slug'  => $this->slug,
            'status'=> $this->status,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
