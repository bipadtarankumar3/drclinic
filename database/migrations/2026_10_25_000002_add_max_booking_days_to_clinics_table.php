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
        if (Schema::hasTable('clinics') && !Schema::hasColumn('clinics', 'max_booking_days')) {
            Schema::table('clinics', function (Blueprint $table) {
                $table->unsignedInteger('max_booking_days')->default(90)->after('allow_cash_booking');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('clinics') && Schema::hasColumn('clinics', 'max_booking_days')) {
            Schema::table('clinics', function (Blueprint $table) {
                $table->dropColumn('max_booking_days');
            });
        }
    }
};
