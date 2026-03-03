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
    Schema::create('product_batch', function (Blueprint $table) {
        $table->id('batch_id');

        $table->unsignedBigInteger('product_id');
        $table->string('lot_number', 50);

        $table->date('manufacturing_date')->nullable();
        $table->date('expiration_date');

        $table->integer('quantity_received');
        $table->integer('quantity_remaining');

        $table->date('date_received');

        $table->enum('status', ['Active', 'Expired', 'Depleted'])
              ->default('Active');

        $table->foreign('product_id')
              ->references('product_id')->on('products')
              ->cascadeOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('product_batch');
}
};
