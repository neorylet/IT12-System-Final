<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('inventory_transaction', function (Blueprint $table) {
        $table->id('transaction_id');

        $table->enum('transaction_type', ['IN', 'OUT', 'ADJUSTMENT', 'RETURN']);

        $table->unsignedBigInteger('renter_id')->nullable();
        $table->unsignedBigInteger('shelf_id')->nullable();

        $table->timestamp('transaction_date')->useCurrent();

        $table->string('reference_no', 100)->nullable();
        $table->text('remarks')->nullable();

        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('approved_by')->nullable();
        $table->timestamp('approved_at')->nullable();

        $table->timestamp('created_at')->useCurrent();

        $table->foreign('renter_id')
              ->references('renter_id')->on('renters')
              ->nullOnDelete()->cascadeOnUpdate();

        $table->foreign('shelf_id')
              ->references('shelf_id')->on('shelves')
              ->nullOnDelete()->cascadeOnUpdate();

        $table->foreign('created_by')
              ->references('id')->on('users')
              ->nullOnDelete()->cascadeOnUpdate();

        $table->foreign('approved_by')
              ->references('id')->on('users')
              ->nullOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('inventory_transaction');
}
};
