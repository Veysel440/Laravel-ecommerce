<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\ProductSearchRequest;
use App\Models\Product;
use App\Support\ApiResponse;
use App\Support\Money;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Builder as ScoutBuilder;

class SearchController extends Controller
{
    public function products(ProductSearchRequest $r)
    {
        $q        = (string) $r->input('q','');
        $brandId  = $r->integer('brand_id');
        $cats     = (array) $r->input('categories',[]);
        $pmin     = $r->input('price_min'); // decimal
        $pmax     = $r->input('price_max');
        $sort     = (string) $r->input('sort','relevance');
        $page     = max(1, (int) $r->input('page',1));
        $per      = min(50, max(1, (int) $r->input('per_page',20)));

        $filters = [];
        if ($brandId) $filters[] = "brand_id = {$brandId}";
        if (!empty($cats)) {
            $catsFilt = collect($cats)->map(fn($c)=> "categories = \"$c\"")->implode(' OR ');
            $filters[] = "({$catsFilt})";
        }
        // minor
        if ($pmin !== null || $pmax !== null) {
            $min = $pmin !== null ? (int) round(((float)$pmin)*100) : null;
            $max = $pmax !== null ? (int) round(((float)$pmax)*100) : null;
            if ($min !== null) $filters[] = "price_min_minor >= {$min}";
            if ($max !== null) $filters[] = "price_max_minor <= {$max}";
        }
        $filterExpr = implode(' AND ', array_filter($filters));

        try {
            /** @var ScoutBuilder $builder */
            $builder = Product::search($q);
            if ($filterExpr) $builder->where($filterExpr);

            // sort
            $sortRules = match($sort) {
                'price_asc'  => ['price_min_minor:asc'],
                'price_desc' => ['price_min_minor:desc'],
                'newest'     => ['created_at:desc'],
                default      => null,
            };
            if ($sortRules) $builder->orderBy(...$sortRules);

            $result = $builder->paginate($per, 'page', $page);

            $items = collect($result->items())->map(function($p){
                return [
                    'id'    => $p->id,
                    'name'  => $p->name,
                    'slug'  => $p->slug,
                    'brand' => $p->brand_name ?? null,
                    'categories'=> $p->categories ?? [],
                    'price'=> [
                        'min' => Money::fromMinor((int)$p->price_min_minor, $p->currency ?? 'TRY'),
                        'max' => Money::fromMinor((int)$p->price_max_minor, $p->currency ?? 'TRY'),
                        'currency'=> $p->currency ?? 'TRY',
                    ],
                ];
            });

            return ApiResponse::ok([
                'items'=>$items,
                'pagination'=>[
                    'total'=>$result->total(),
                    'per_page'=>$result->perPage(),
                    'current_page'=>$result->currentPage(),
                    'last_page'=>$result->lastPage(),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::warning('search.meili.error',['e'=>$e]);


            $qelo = Product::query()->with(['brand','images'])
                ->where('status','active')
                ->when($q, fn($qq)=> $qq->where(function($w) use($q){
                    $w->where('name','like',"%{$q}%")
                        ->orWhere('description','like',"%{$q}%");
                }))
                ->when($brandId, fn($qq)=> $qq->where('brand_id',$brandId))
                ->when(!empty($cats), fn($qq)=> $qq->whereHas('categories', fn($c)=> $c->whereIn('slug',$cats)));

            if ($sort === 'price_asc' || $sort === 'price_desc') {
                $qelo->withMin('skus','price_minor')->withMax('skus','price_minor');
                $qelo->orderBy('skus_min_price_minor', $sort === 'price_asc' ? 'asc' : 'desc');
            } elseif ($sort === 'newest') {
                $qelo->latest();
            }

            $pag = $qelo->paginate($per, ['*'], 'page', $page);
            $items = $pag->getCollection()->map(function($p){
                $min = $p->skus_min_price_minor ?? $p->skus()->min('price_minor') ?? 0;
                $max = $p->skus_max_price_minor ?? $p->skus()->max('price_minor') ?? 0;
                $ccy = $p->skus()->value('currency') ?? 'TRY';
                return [
                    'id'=>$p->id,'name'=>$p->name,'slug'=>$p->slug,
                    'brand'=>$p->brand?->name,
                    'categories'=>$p->categories->pluck('slug'),
                    'price'=>['min'=>Money::fromMinor((int)$min,$ccy),'max'=>Money::fromMinor((int)$max,$ccy),'currency'=>$ccy],
                ];
            });

            return ApiResponse::ok([
                'items'=>$items,
                'pagination'=>[
                    'total'=>$pag->total(),'per_page'=>$pag->perPage(),
                    'current_page'=>$pag->currentPage(),'last_page'=>$pag->lastPage(),
                ],
                'meta'=>['fallback'=>'eloquent'],
            ]);
        }
    }
}
