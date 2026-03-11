<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_transaction', function (Blueprint $table) {
            $table->string('status', 20)->default('Approved')->after('remarks');
            $table->text('review_remarks')->nullable()->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('inventory_transaction', function (Blueprint $table) {
            $table->dropColumn(['status', 'review_remarks']);
        });
    }
};