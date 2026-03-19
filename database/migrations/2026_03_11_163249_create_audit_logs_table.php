<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {

            $table->id('log_id');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('action',100);
            $table->string('module',100);

            $table->text('description');

            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_no',100)->nullable();

            $table->string('ip_address',45)->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};