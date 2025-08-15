<?php

namespace App\Services\Catalog;

use Illuminate\Support\Facades\Cache;
class ProductService
{
    public function paginate(array $filters)
    {
        $key = 'cat:list:'.md5(json_encode($filters));
        return Cache::remember($key, now()->addMinutes(5), function() use($filters){
            $q = \App\Models\Product::query()->with(['brand','images'])->where('status','active');

        if (!empty($filters['q'])) {
            $q->whereFullText(['name','description'], $filters['q']);
        }
        if (!empty($filters['brand'])) {
            $q->whereHas('brand', fn($b)=> $b->where('slug',$filters['brand']));
        }
        if (!empty($filters['category'])) {
            $q->whereHas('categories', fn($c)=> $c->where('slug',$filters['category']));
        }
        if (!empty($filters['min'])) { $q->whereHas('skus', fn($s)=> $s->where('price','>=',$filters['min'])); }
        if (!empty($filters['max'])) { $q->whereHas('skus', fn($s)=> $s->where('price','<=',$filters['max'])); }

        if (($filters['sort'] ?? null) === 'price_asc')  { $q->withMin('skus','price')->orderBy('skus_min_price'); }
        if (($filters['sort'] ?? null) === 'price_desc') { $q->withMax('skus','price')->orderByDesc('skus_max_price'); }
        if (($filters['sort'] ?? null) === 'newest')     { $q->orderByDesc('id'); }

            $per = $filters['per_page'] ?? 20;
            return $q->paginate($per);
        });
    }

    public function showBySlug(string $slug): \App\Models\Product
    {
        return Cache::remember("cat:product:{$slug}", now()->addMinutes(10), function() use($slug){
            return \App\Models\Product::where('slug',$slug)
                ->where('status','active')
                ->with(['brand','images','categories','skus.inventory','skus.optionValues.option'])
                ->firstOrFail();
        });
    }
}
