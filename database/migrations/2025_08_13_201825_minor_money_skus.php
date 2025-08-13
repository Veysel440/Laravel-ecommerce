<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('skus', function(Blueprint $t){
            $t->unsignedBigInteger('price_minor')->default(0)->after('product_id');
            $t->unsignedBigInteger('compare_at_price_minor')->nullable()->after('price_minor');
        });
        DB::statement('UPDATE skus SET price_minor = ROUND(price*100), compare_at_price_minor = ROUND(compare_at_price*100)');
        Schema::table('skus', function(Blueprint $t){
            $t->dropColumn(['price','compare_at_price']);
        });
    }
    public function down(): void {
        Schema::table('skus', function(Blueprint $t){
            $t->decimal('price',12,2)->after('product_id');
            $t->decimal('compare_at_price',12,2)->nullable()->after('price');
        });
        DB::statement('UPDATE skus SET price = price_minor/100, compare_at_price = compare_at_price_minor/100');
        Schema::table('skus', function(Blueprint $t){
            $t->dropColumn(['price_minor','compare_at_price_minor']);
        });
    }
};
