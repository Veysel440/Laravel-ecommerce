<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function(Blueprint $t){
            $t->unsignedSmallInteger('tax_rate_bp')->default(0)->after('status'); // basis points
        });
        DB::statement('UPDATE products SET tax_rate_bp = ROUND(tax_rate*100)');
        Schema::table('products', function(Blueprint $t){ $t->dropColumn('tax_rate'); });
    }
    public function down(): void {
        Schema::table('products', function(Blueprint $t){
            $t->decimal('tax_rate',5,2)->default(0)->after('status');
        });
        DB::statement('UPDATE products SET tax_rate = tax_rate_bp/100');
        Schema::table('products', function(Blueprint $t){ $t->dropColumn('tax_rate_bp'); });
    }
};
