<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function(Blueprint $t){
            $t->id();
            $t->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->enum('status',['draft','active','archived'])->default('draft')->index();
            $t->decimal('tax_rate',5,2)->default(0);
            $t->json('meta')->nullable();
            $t->timestamps();
            $t->fullText(['name','description']);
        });
        Schema::create('category_product', function(Blueprint $t){
            $t->foreignId('category_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->primary(['category_id','product_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
    }
};
