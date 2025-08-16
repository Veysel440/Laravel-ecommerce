<?php

namespace Tests\Feature;

use App\Models\Sku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_to_cart_and_intent_confirm(): void
    {
        $this->seed(\Database\Seeders\DemoCatalogSeeder::class);
        $sku = Sku::with('product')->first();

        $this->postJson('/api/v1/cart/items', [
            'sku_id'=>$sku->id,'qty'=>2
        ], ['Idempotency-Key'=>\Str::uuid()])
            ->assertOk();

        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/v1/checkout/payment-intent', [
            'provider'=>'null'
        ], ['Idempotency-Key'=>\Str::uuid()])
            ->assertOk();

        $this->postJson('/api/v1/checkout/confirm', [
            'payment_reference'=>'TEST-OK','provider'=>'null'
        ], ['Idempotency-Key'=>\Str::uuid()])
            ->assertCreated()
            ->assertJsonPath('success', true);
    }
}
