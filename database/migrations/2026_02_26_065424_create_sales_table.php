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
    Schema::create('sales', function (Blueprint $table) {
        $table->id('sale_id');

        $table->timestamp('sale_date')->useCurrent();
        $table->decimal('total_amount', 10, 2);

        $table->unsignedBigInteger('processed_by')->nullable();
        $table->enum('payment_method', ['Cash', 'GCash', 'Card']);

        $table->foreign('processed_by')
              ->references('id')->on('users')
              ->nullOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('sales');
}
};
