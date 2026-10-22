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
        Schema::table('clinics', function (Blueprint $table) {
            if (!Schema::hasColumn('clinics', 'brand_display_mode')) {
                $table->string('brand_display_mode', 20)->default('both')->after('logo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            if (Schema::hasColumn('clinics', 'brand_display_mode')) {
                $table->dropColumn('brand_display_mode');
            }
        });
    }
};
