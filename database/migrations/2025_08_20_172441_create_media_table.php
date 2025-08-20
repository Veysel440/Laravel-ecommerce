<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('media', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('disk', 32);
            $t->string('path', 255)->unique();
            $t->string('original_name', 191)->nullable();
            $t->string('mime', 64);
            $t->unsignedBigInteger('size');
            $t->unsignedInteger('width')->nullable();
            $t->unsignedInteger('height')->nullable();
            $t->string('checksum', 64)->index();
            $t->json('variants')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('media'); }
};
