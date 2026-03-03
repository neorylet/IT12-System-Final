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
    Schema::create('sales_items', function (Blueprint $table) {
        $table->id('sale_item_id');

        $table->unsignedBigInteger('sale_id');
        $table->unsignedBigInteger('product_id');
        $table->unsignedBigInteger('batch_id')->nullable();

        $table->integer('quantity');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('subtotal', 10, 2);

        $table->foreign('sale_id')
              ->references('sale_id')->on('sales')
              ->cascadeOnDelete()->cascadeOnUpdate();

        $table->foreign('product_id')
              ->references('product_id')->on('products')
              ->restrictOnDelete()->cascadeOnUpdate();

        $table->foreign('batch_id')
              ->references('batch_id')->on('product_batch')
              ->nullOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('sales_items');
}
};
