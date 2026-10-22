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
            $table->string('topbar_tagline')->nullable()->default('Your Health, Our Priority')->after('secondary_color');
            $table->string('topbar_hours')->nullable()->default('Open 7 Days a Week')->after('topbar_tagline');
            $table->boolean('show_topbar')->default(true)->after('topbar_hours');
            $table->boolean('show_doctor_portal_link')->default(false)->after('show_topbar');
            $table->string('currency_text')->nullable()->default('INR (₹)')->after('show_doctor_portal_link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn([
                'topbar_tagline',
                'topbar_hours',
                'show_topbar',
                'show_doctor_portal_link',
                'currency_text',
            ]);
        });
    }
};
