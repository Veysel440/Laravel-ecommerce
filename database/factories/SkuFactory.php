<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkuFactory extends Factory
{
    protected $model = \App\Models\Sku::class;
    public function definition(): array {
        return [
            'product_id'=> \App\Models\Product::factory(),
            'code'=> strtoupper(fake()->bothify('SKU-###??')),
            'price_minor'=> fake()->numberBetween(9_99, 9_99*100),
            'compare_at_price_minor'=> null,
            'currency'=>'TRY',
        ];
    }
}
