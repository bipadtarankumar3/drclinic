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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->float('pay_amount')->nullable();
            $table->float('pay_additional_amount')->nullable();
            $table->text('payment_terms_and_condition')->nullable();
            $table->text('payment_permission_status')->nullable();
            $table->text('pay_key')->nullable();
            $table->text('pay_secret_key')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
