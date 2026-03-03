<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('renters', function (Blueprint $table) {
            $table->string('renter_company_name')->after('renter_last_name');
        });
    }

    public function down(): void
    {
        Schema::table('renters', function (Blueprint $table) {
            $table->dropColumn('renter_company_name');
        });
    }
};