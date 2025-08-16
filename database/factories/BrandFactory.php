<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = \App\Models\Brand::class;
    public function definition(): array {
        $name = fake()->unique()->company();
        return ['name'=>$name,'slug'=>\Str::slug($name)];
    }
}
