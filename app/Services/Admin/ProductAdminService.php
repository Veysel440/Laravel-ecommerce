<?php

namespace App\Services\Admin;

use App\Models\{Product, ProductImage, ProductOption, ProductOptionValue, Sku, Inventory};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductAdminService
{
    public function create(array $data): Product
    {
        return DB::transaction(function() use($data){
            $slug = $data['slug'] ?? Str::slug($data['name']);
            $p = Product::create([
                'brand_id'=>$data['brand_id'] ?? null,
                'name'=>$data['name'],
                'slug'=>$slug,
                'description'=>$data['description'] ?? null,
                'status'=>$data['status'],
                'tax_rate'=>$data['tax_rate'],
                'meta'=>$data['meta'] ?? null,
            ]);
            if (!empty($data['category_ids'])) $p->categories()->sync($data['category_ids']);

            foreach (($data['images'] ?? []) as $img) {
                ProductImage::create(['product_id'=>$p->id,'path'=>$img['path'],'sort'=>$img['sort'] ?? 0]);
            }


            $optMap = [];
            foreach (($data['options'] ?? []) as $opt) {
                $o = ProductOption::create(['product_id'=>$p->id,'name'=>$opt['name']]);
                $optMap[$opt['name']] = [];
                foreach ($opt['values'] as $val) {
                    $v = ProductOptionValue::create(['product_option_id'=>$o->id,'value'=>$val]);
                    $optMap[$opt['name']][$val] = $v->id;
                }
            }


            foreach ($data['skus'] as $sku) {
                $s = Sku::create([
                    'product_id'=>$p->id,
                    'code'=>$sku['code'],
                    'price'=>$sku['price'],
                    'compare_at_price'=>$sku['compare_at_price'] ?? null,
                    'currency'=>$sku['currency'],
                    'weight'=>$sku['weight'] ?? null,
                    'dimensions'=>$sku['dimensions'] ?? null,
                ]);
                // option_values map
                $pivotIds = [];
                foreach (($sku['option_values'] ?? []) as $optName=>$valName) {
                    if (isset($optMap[$optName][$valName])) $pivotIds[] = $optMap[$optName][$valName];
                }
                if ($pivotIds) $s->optionValues()->sync($pivotIds);
                Inventory::create(['sku_id'=>$s->id,'qty'=>$sku['inventory_qty'],'reserved_qty'=>0]);
            }

            return $p->load(['brand','categories','images','skus.inventory','options.values']);
        });
    }

    public function update(Product $p, array $data): Product
    {
        return DB::transaction(function() use($p,$data){
            $p->update([
                'brand_id'=>$data['brand_id'] ?? $p->brand_id,
                'name'=>$data['name'] ?? $p->name,
                'slug'=>$data['slug'] ?? $p->slug,
                'description'=>$data['description'] ?? $p->description,
                'status'=>$data['status'] ?? $p->status,
                'tax_rate'=>$data['tax_rate'] ?? $p->tax_rate,
                'meta'=>$data['meta'] ?? $p->meta,
            ]);
            if (isset($data['category_ids'])) $p->categories()->sync($data['category_ids']);
            if (isset($data['images'])) {
                $p->images()->delete();
                foreach ($data['images'] as $img) {
                    ProductImage::create(['product_id'=>$p->id,'path'=>$img['path'],'sort'=>$img['sort'] ?? 0]);
                }
            }
            return $p->load(['brand','categories','images','skus.inventory','options.values']);
        });
    }
}
