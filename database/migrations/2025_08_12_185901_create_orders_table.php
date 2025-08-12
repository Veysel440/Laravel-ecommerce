<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('number')->unique();
            $t->enum('status',['pending','paid','shipped','completed','cancelled','refunded'])->default('pending')->index();
            $t->string('currency',3)->default('TRY');
            $t->json('totals');
            $t->json('billing_address');
            $t->json('shipping_address');
            $t->timestamps();
        });
        Schema::create('order_items', function(Blueprint $t){
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('sku_id')->constrained('skus')->restrictOnDelete();
            $t->integer('qty');
            $t->decimal('unit_price',12,2);
            $t->decimal('tax',12,2)->default(0);
            $t->decimal('total',12,2);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
