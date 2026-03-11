<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_transaction', function (Blueprint $table) {

            if (!Schema::hasColumn('inventory_transaction', 'status')) {
                $table->string('status', 20)
                      ->default('Approved')
                      ->after('remarks');
            }

            if (!Schema::hasColumn('inventory_transaction', 'review_remarks')) {
                $table->text('review_remarks')
                      ->nullable()
                      ->after('approved_at');
            }

        });
    }

    public function down(): void
    {
        Schema::table('inventory_transaction', function (Blueprint $table) {

            if (Schema::hasColumn('inventory_transaction', 'review_remarks')) {
                $table->dropColumn('review_remarks');
            }

            if (Schema::hasColumn('inventory_transaction', 'status')) {
                $table->dropColumn('status');
            }

        });
    }
};