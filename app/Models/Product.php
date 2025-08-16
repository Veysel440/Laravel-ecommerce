<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $fillable=['brand_id','name','slug','description','status','tax_rate_bp','meta'];
    protected $casts=['meta'=>'array','tax_rate_bp'=>'integer'];

    public function toSearchableArray(): array
    {
        $this->loadMissing([
            'brand:id,name',
            'categories:id,slug',
            'skus:id,product_id,price_minor,currency'
        ]);

        $prices = $this->skus->pluck('price_minor');
        $priceMin = $prices->min() ?? 0;
        $priceMax = $prices->max() ?? 0;

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'slug'      => $this->slug,
            'description'=> strip_tags((string)$this->description),
            'status'    => $this->status,
            'brand_id'  => (int) $this->brand_id,
            'brand_name'=> (string) optional($this->brand)->name,
            'categories'=> $this->categories->pluck('slug')->all(),
            'category_ids'=> $this->categories->pluck('id')->all(),
            'price_min_minor' => (int) $priceMin,
            'price_max_minor' => (int) $priceMax,
            'currency'  => $this->skus->first()->currency ?? 'TRY',
            'created_at'=> optional($this->created_at)?->toISOString(),
        ];
    }

    public function searchableAs(): string { return 'products'; }

    public function shouldBeSearchable(): bool
    { return $this->status === 'active'; }
}
