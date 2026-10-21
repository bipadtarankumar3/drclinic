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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('platform_name')->nullable()->default('DrClinic SaaS')->after('clinic_id');
            $table->string('platform_email')->nullable()->default('support@drclinic.com')->after('platform_name');
            $table->integer('default_trial_days')->nullable()->default(14)->after('pay_additional_amount');
            $table->string('currency_symbol', 10)->nullable()->default('₹')->after('default_trial_days');
            $table->string('currency_code', 10)->nullable()->default('INR')->after('currency_symbol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'platform_name',
                'platform_email',
                'default_trial_days',
                'currency_symbol',
                'currency_code',
            ]);
        });
    }
};
