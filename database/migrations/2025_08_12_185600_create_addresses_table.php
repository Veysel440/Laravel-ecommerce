<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('addresses', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->enum('type',['billing','shipping']);
            $t->string('full_name');
            $t->string('phone');
            $t->string('line1');
            $t->string('line2')->nullable();
            $t->string('city');
            $t->string('state')->nullable();
            $t->string('postal_code');
            $t->string('country',2)->index();
            $t->boolean('is_default')->default(false)->index();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('addresses'); }
};
