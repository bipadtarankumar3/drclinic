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
            if (!Schema::hasColumn('clinics', 'extra_features')) {
                $table->json('extra_features')->nullable()->after('status');
            }
            if (!Schema::hasColumn('clinics', 'custom_quotas')) {
                $table->json('custom_quotas')->nullable()->after('extra_features');
            }
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            if (!Schema::hasColumn('subscription_plans', 'annual_price')) {
                $table->decimal('annual_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('subscription_plans', 'currency')) {
                $table->string('currency', 10)->default('INR')->after('annual_price');
            }
            if (!Schema::hasColumn('subscription_plans', 'max_staff')) {
                $table->integer('max_staff')->default(5)->after('trial_days');
            }
            if (!Schema::hasColumn('subscription_plans', 'max_bookings')) {
                $table->integer('max_bookings')->default(100)->after('max_staff');
            }
            if (!Schema::hasColumn('subscription_plans', 'storage_quota_mb')) {
                $table->integer('storage_quota_mb')->default(1024)->after('max_bookings');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn(['extra_features', 'custom_quotas']);
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn(['annual_price', 'currency', 'max_staff', 'max_bookings', 'storage_quota_mb']);
        });
    }
};
