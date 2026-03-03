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
    Schema::create('inventory_transaction_items', function (Blueprint $table) {
        $table->id('transaction_item_id');

        $table->unsignedBigInteger('transaction_id');
        $table->unsignedBigInteger('batch_id');

        $table->integer('quantity');
        $table->decimal('unit_cost', 10, 2)->nullable();

        $table->foreign('transaction_id')
              ->references('transaction_id')->on('inventory_transaction')
              ->cascadeOnDelete()->cascadeOnUpdate();

        $table->foreign('batch_id')
              ->references('batch_id')->on('product_batch')
              ->restrictOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('inventory_transaction_items');
}
};
