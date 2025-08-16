<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    protected $model = \App\Models\Inventory::class;
    public function definition(): array {
        return ['qty'=> fake()->numberBetween(5,200),'reserved_qty'=>0];
    }
}
