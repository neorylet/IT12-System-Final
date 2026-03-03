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
    Schema::create('inventory', function (Blueprint $table) {
        $table->id('inventory_id');

        $table->unsignedBigInteger('product_id')->unique();
        $table->integer('quantity_on_hand');
        $table->integer('reorder_level')->default(5);

        $table->timestamp('last_updated')
              ->useCurrent()
              ->useCurrentOnUpdate();

        $table->foreign('product_id')
              ->references('product_id')->on('products')
              ->cascadeOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('inventory');
}
};
