<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoCatalogSeeder extends Seeder {
    public function run(): void {
        \App\Models\Brand::factory(5)->create();
        \App\Models\Category::factory(6)->create();

        \App\Models\Product::factory(30)
            ->has(\App\Models\Sku::factory()->count(2)
                ->afterCreating(function($sku){
                    \App\Models\Inventory::firstOrCreate(['sku_id'=>$sku->id], ['qty'=>fake()->numberBetween(5,50),'reserved_qty'=>0]);
                })
            )
            ->create()
            ->each(function($p){
                $p->categories()->attach(\App\Models\Category::inRandomOrder()->limit(2)->pluck('id'));
            });


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
