<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_products(): void
    {
        $this->seed(\Database\Seeders\DemoCatalogSeeder::class);

        $this->getJson('/api/v1/products')
            ->assertOk()
            ->assertJsonStructure(['success','data'=>[]]);
    }

    public function test_show_product(): void
    {
        $this->seed(\Database\Seeders\DemoCatalogSeeder::class);
        $p = Product::first();
        $this->getJson("/api/v1/products/{$p->slug}")
            ->assertOk()
            ->assertJsonPath('success', true);
    }
}
