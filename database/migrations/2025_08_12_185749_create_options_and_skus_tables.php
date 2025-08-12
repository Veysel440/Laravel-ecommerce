<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_options', function(Blueprint $t){
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('name'); // Color, Size
            $t->timestamps();
        });
        Schema::create('product_option_values', function(Blueprint $t){
            $t->id();
            $t->foreignId('product_option_id')->constrained()->cascadeOnDelete();
            $t->string('value'); // Red, XL
            $t->timestamps();
        });
        Schema::create('skus', function(Blueprint $t){
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('code')->unique();
            $t->decimal('price',12,2);
            $t->decimal('compare_at_price',12,2)->nullable();
            $t->string('currency',3)->default('TRY')->index();
            $t->decimal('weight',10,3)->nullable();
            $t->json('dimensions')->nullable();
            $t->timestamps();
            $t->index(['product_id','price']);
        });
        Schema::create('sku_option_values', function(Blueprint $t){
            $t->foreignId('sku_id')->constrained('skus')->cascadeOnDelete();
            $t->foreignId('product_option_value_id')->constrained()->cascadeOnDelete();
            $t->primary(['sku_id','product_option_value_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('sku_option_values');
        Schema::dropIfExists('skus');
        Schema::dropIfExists('product_option_values');
        Schema::dropIfExists('product_options');
    }
};
