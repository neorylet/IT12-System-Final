<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shelves', function (Blueprint $table) {

            // PRIMARY KEY
            $table->id('shelf_id');

            $table->string('shelf_number', 20)->unique();

            // FOREIGN KEY (TYPE-SAFE VERSION)
            $table->foreignId('renter_id')
                  ->nullable()
                  ->constrained('renters', 'renter_id')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            $table->decimal('monthly_rent', 10, 2);

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->enum('shelf_status', ['Available', 'Occupied'])
                  ->default('Available');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shelves');
    }
};