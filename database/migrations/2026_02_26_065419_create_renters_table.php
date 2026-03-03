<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('renters', function (Blueprint $table) {

            // PRIMARY KEY (BIGINT UNSIGNED)
            $table->id('renter_id');

            $table->string('renter_first_name');
            $table->string('renter_last_name');
            $table->string('contact_person');
            $table->string('contact_number', 50);
            $table->string('email')->unique();

            $table->date('contract_start');
            $table->date('contract_end');

            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renters');
    }
};