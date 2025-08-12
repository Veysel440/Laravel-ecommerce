<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'slug'   => $this->slug,
            'name'   => $this->name,
            'description' => $this->description,
            'brand'  => $this->whenLoaded('brand', fn()=>[
                'id'=>$this->brand->id,'name'=>$this->brand->name,'slug'=>$this->brand->slug
            ]),
            'images' => $this->whenLoaded('images', fn()=> $this->images->map->only(['id','path','sort'])),
            'categories' => $this->whenLoaded('categories', fn()=> $this->categories->map->only(['id','name','slug'])),
            'tax_rate' => (float)$this->tax_rate,
            'skus'   => SkuResource::collection($this->whenLoaded('skus')),
        ];
    }
}
