<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventories', function(Blueprint $t){
            $t->id();
            $t->foreignId('sku_id')->constrained('skus')->cascadeOnDelete();
            $t->integer('qty')->default(0);
            $t->integer('reserved_qty')->default(0);
            $t->timestamps();
            $t->unique('sku_id');
        });
    }
    public function down(): void { Schema::dropIfExists('inventories'); }
};
