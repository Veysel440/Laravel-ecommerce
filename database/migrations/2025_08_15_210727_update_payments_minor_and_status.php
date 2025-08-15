<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('payments', function(Blueprint $t){
            if (!Schema::hasColumn('payments','amount_minor')) $t->unsignedBigInteger('amount_minor')->default(0)->after('status');
            if (!Schema::hasColumn('payments','currency'))     $t->char('currency',3)->default('TRY')->after('amount_minor');
            if (!Schema::hasColumn('payments','reference'))    $t->string('reference',191)->nullable()->after('provider');
        });
    }
    public function down(): void {
        Schema::table('payments', function(Blueprint $t){
            if (Schema::hasColumn('payments','amount_minor')) $t->dropColumn('amount_minor');
            if (Schema::hasColumn('payments','currency'))     $t->dropColumn('currency');
            if (Schema::hasColumn('payments','reference'))    $t->dropColumn('reference');
        });
    }
};
