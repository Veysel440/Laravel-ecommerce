<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('refunds', function(Blueprint $t){
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $t->string('provider',32);
            $t->string('reference',191)->index();
            $t->unsignedBigInteger('amount_minor');
            $t->char('currency',3)->default('TRY');
            $t->string('status',24)->default('succeeded');
            $t->json('raw')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('refunds'); }
};
