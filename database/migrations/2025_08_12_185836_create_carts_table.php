<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('carts', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->uuid('session_id')->unique()->index();
            $t->string('currency',3)->default('TRY');
            $t->json('totals')->nullable();
            $t->timestamps();
        });
        Schema::create('cart_items', function(Blueprint $t){
            $t->id();
            $t->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $t->foreignId('sku_id')->constrained('skus')->cascadeOnDelete();
            $t->integer('qty');
            $t->json('price_snapshot');
            $t->timestamps();
            $t->unique(['cart_id','sku_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
