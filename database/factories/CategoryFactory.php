<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = \App\Models\Category::class;
    public function definition(): array {
        $name = fake()->unique()->word();
        return ['name'=>$name,'slug'=>\Str::slug($name),'status'=>'active'];
    }
}
