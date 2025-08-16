<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;
    public function definition(): array {
        $name = fake()->unique()->words(3, true);
        return [
            'brand_id'=> \App\Models\Brand::factory(),
            'name'=>$name,
            'slug'=> \Str::slug($name.'-'.fake()->unique()->numberBetween(1,9999)),
            'description'=> fake()->paragraph(),
            'status'=>'active',
            'tax_rate_bp'=> 1800,
            'meta'=>[],
        ];
    }
}
