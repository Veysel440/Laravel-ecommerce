<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function(Blueprint $t){
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->string('provider');
            $t->enum('status',['initiated','authorized','captured','failed','refunded'])->index();
            $t->json('raw_response')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('payments'); }
};
