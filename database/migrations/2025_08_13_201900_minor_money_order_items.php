<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('order_items', function(Blueprint $t){
            $t->unsignedBigInteger('unit_price_minor')->after('qty')->default(0);
            $t->unsignedBigInteger('tax_minor')->after('unit_price_minor')->default(0);
            $t->unsignedBigInteger('total_minor')->after('tax_minor')->default(0);
        });
        DB::statement('UPDATE order_items SET unit_price_minor=ROUND(unit_price*100), tax_minor=ROUND(tax*100), total_minor=ROUND(total*100)');
        Schema::table('order_items', function(Blueprint $t){
            $t->dropColumn(['unit_price','tax','total']);
        });
    }
    public function down(): void {
        Schema::table('order_items', function(Blueprint $t){
            $t->decimal('unit_price',12,2)->after('qty');
            $t->decimal('tax',12,2)->default(0)->after('unit_price');
            $t->decimal('total',12,2)->after('tax');
        });
        DB::statement('UPDATE order_items SET unit_price=unit_price_minor/100, tax=tax_minor/100, total=total_minor/100');
        Schema::table('order_items', function(Blueprint $t){
            $t->dropColumn(['unit_price_minor','tax_minor','total_minor']);
        });
    }
};
