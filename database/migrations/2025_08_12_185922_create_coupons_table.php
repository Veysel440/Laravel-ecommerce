<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('coupons', function(Blueprint $t){
            $t->id();
            $t->string('code')->unique();
            $t->enum('type',['percent','fixed']);
            $t->decimal('value',12,2);
            $t->timestamp('starts_at')->nullable();
            $t->timestamp('ends_at')->nullable();
            $t->integer('usage_limit')->nullable();
            $t->integer('used_count')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('coupons'); }
};
