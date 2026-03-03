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
    Schema::create('products', function (Blueprint $table) {
        $table->id('product_id');

        $table->string('product_name', 150);
        $table->text('description')->nullable();
        $table->string('category', 100);
        $table->decimal('price', 10, 2);

        $table->unsignedBigInteger('shelf_id')->nullable();
        $table->unsignedBigInteger('renter_id')->nullable();

        $table->enum('status', ['Pending', 'Approved', 'Rejected'])
              ->default('Pending');

        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('approved_by')->nullable();

        $table->timestamp('created_at')->useCurrent();

        $table->foreign('shelf_id')
              ->references('shelf_id')->on('shelves')
              ->nullOnDelete()->cascadeOnUpdate();

        $table->foreign('renter_id')
              ->references('renter_id')->on('renters')
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
    Schema::dropIfExists('products');
}

};
