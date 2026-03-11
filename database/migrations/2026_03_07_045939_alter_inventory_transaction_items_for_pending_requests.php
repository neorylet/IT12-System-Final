<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_transaction_items', function (Blueprint $table) {

            if (!Schema::hasColumn('inventory_transaction_items', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->after('transaction_id');
            }

            if (!Schema::hasColumn('inventory_transaction_items', 'lot_number')) {
                $table->string('lot_number', 50)->nullable()->after('batch_id');
            }

            if (!Schema::hasColumn('inventory_transaction_items', 'manufacturing_date')) {
                $table->date('manufacturing_date')->nullable()->after('lot_number');
            }

            if (!Schema::hasColumn('inventory_transaction_items', 'expiration_date')) {
                $table->date('expiration_date')->nullable()->after('manufacturing_date');
            }

        });

        // backfill product_id from existing batches
        DB::statement("
            UPDATE inventory_transaction_items iti
            INNER JOIN product_batch pb 
                ON iti.batch_id = pb.batch_id
            SET iti.product_id = pb.product_id
            WHERE iti.product_id IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('inventory_transaction_items', function (Blueprint $table) {

            if (Schema::hasColumn('inventory_transaction_items', 'expiration_date')) {
                $table->dropColumn('expiration_date');
            }

            if (Schema::hasColumn('inventory_transaction_items', 'manufacturing_date')) {
                $table->dropColumn('manufacturing_date');
            }

            if (Schema::hasColumn('inventory_transaction_items', 'lot_number')) {
                $table->dropColumn('lot_number');
            }

            if (Schema::hasColumn('inventory_transaction_items', 'product_id')) {
                $table->dropColumn('product_id');
            }

        });
    }
};