<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventory_transaction_items', function (Blueprint $table) {
            $table->string('adjustment_mode', 20)->nullable()->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('inventory_transaction_items', function (Blueprint $table) {
            $table->dropColumn('adjustment_mode');
        });
    }
};