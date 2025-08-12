<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoCatalogSeeder extends Seeder {
    public function run(): void {
        $brand = \App\Models\Brand::firstOrCreate(['slug'=>'acme'],['name'=>'ACME']);
        $cat = \App\Models\Category::firstOrCreate(['slug'=>'electronics'],['name'=>'Electronics','status'=>'active']);
        $p = \App\Models\Product::firstOrCreate(['slug'=>'acme-phone'],[
            'name'=>'ACME Phone','status'=>'active','brand_id'=>$brand->id,'tax_rate'=>20
        ]);
        $p->categories()->syncWithoutDetaching([$cat->id]);
        $p->images()->firstOrCreate(['path'=>'products/acme-phone.jpg']);
        $sku = $p->skus()->firstOrCreate(['code'=>'ACME-PHONE-64'],['price'=>9999,'currency'=>'TRY']);
        $sku->inventory()->firstOrCreate([],['qty'=>50,'reserved_qty'=>0]);
    }
}
