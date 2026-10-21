<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Clinics table
        if (!Schema::hasTable('clinics')) {
            Schema::create('clinics', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index(); // Doctor/owner user
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('subdomain')->nullable()->unique();
                $table->string('custom_domain')->nullable()->unique();
                $table->string('logo')->nullable();
                $table->string('banner')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->string('specialization')->nullable();
                $table->text('bio')->nullable();
                $table->decimal('consultation_fee', 10, 2)->default(0);
                $table->string('theme_color', 30)->default('#0d6efd');
                $table->string('secondary_color', 30)->default('#20c997');
                $table->string('razorpay_key')->nullable();
                $table->string('razorpay_secret')->nullable();
                $table->boolean('razorpay_enabled')->default(false);
                $table->boolean('allow_cash_booking')->default(true);
                $table->string('status', 30)->default('trialing'); // trialing, active, expired, suspended
                $table->timestamp('trial_ends_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 2. Subscription plans table
        if (!Schema::hasTable('subscription_plans')) {
            Schema::create('subscription_plans', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->string('billing_cycle', 20)->default('monthly'); // monthly, yearly, lifetime
                $table->integer('duration_days')->default(30);
                $table->integer('trial_days')->default(7);
                $table->json('features')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // 3. Clinic subscriptions table
        if (!Schema::hasTable('clinic_subscriptions')) {
            Schema::create('clinic_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('clinic_id')->index();
                $table->unsignedBigInteger('plan_id')->index();
                $table->string('status', 30)->default('active'); // active, expired, cancelled, pending
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->string('razorpay_payment_id')->nullable();
                $table->string('razorpay_order_id')->nullable();
                $table->decimal('amount', 10, 2)->default(0);
                $table->timestamps();

                $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
                $table->foreign('plan_id')->references('id')->on('subscription_plans')->onDelete('cascade');
            });
        }

        // 4. Clinic custom pages table
        if (!Schema::hasTable('clinic_pages')) {
            Schema::create('clinic_pages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('clinic_id')->index();
                $table->string('title');
                $table->string('slug');
                $table->longText('content')->nullable();
                $table->text('meta_description')->nullable();
                $table->boolean('is_published')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();

                $table->unique(['clinic_id', 'slug']);
                $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            });
        }

        // 5. Activity logs table
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->unsignedBigInteger('clinic_id')->nullable()->index();
                $table->string('action', 100);
                $table->text('description')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
        }

        // 6. Add google_id and avatar to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->after('email')->index();
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('google_id');
            }
        });

        // 7. Add clinic_id to existing tenant-owned tables
        $tenantTables = ['patients', 'orders', 'availabilities', 'time_slots', 'settings'];
        foreach ($tenantTables as $tbl) {
            if (Schema::hasTable($tbl) && !Schema::hasColumn($tbl, 'clinic_id')) {
                Schema::table($tbl, function (Blueprint $table) {
                    $table->unsignedBigInteger('clinic_id')->nullable()->after('id')->index();
                });
            }
        }
    }

    public function down(): void
    {
        $tenantTables = ['settings', 'time_slots', 'availabilities', 'orders', 'patients'];
        foreach ($tenantTables as $tbl) {
            if (Schema::hasTable($tbl) && Schema::hasColumn($tbl, 'clinic_id')) {
                Schema::table($tbl, function (Blueprint $table) {
                    $table->dropColumn('clinic_id');
                });
            }
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('users', 'google_id')) {
                $table->dropColumn('google_id');
            }
        });

        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('clinic_pages');
        Schema::dropIfExists('clinic_subscriptions');
        Schema::dropIfExists('subscription_plans');
        Schema::dropIfExists('clinics');
    }
};
