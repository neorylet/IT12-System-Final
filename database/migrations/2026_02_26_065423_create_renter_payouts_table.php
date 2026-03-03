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
    Schema::create('renter_payouts', function (Blueprint $table) {
        $table->id('payout_id');

        $table->unsignedBigInteger('renter_id');

        $table->date('week_start');
        $table->date('week_end');

        $table->decimal('total_sales', 10, 2);
        $table->decimal('commission_rate', 5, 2);
        $table->decimal('commission_amount', 10, 2);
        $table->decimal('net_amount', 10, 2);

        $table->date('payout_date')->nullable();
        $table->enum('status', ['Pending', 'Released'])
              ->default('Pending');

        $table->unsignedBigInteger('processed_by')->nullable();

        $table->foreign('renter_id')
              ->references('renter_id')->on('renters')
              ->cascadeOnDelete()->cascadeOnUpdate();

        $table->foreign('processed_by')
              ->references('id')->on('users')
              ->nullOnDelete()->cascadeOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('renter_payouts');
}
};
