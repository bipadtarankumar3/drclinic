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
        if (!Schema::hasTable('clinic_inquiries')) {
            Schema::create('clinic_inquiries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('clinic_id')->nullable()->index();
                $table->string('name');
                $table->string('email');
                $table->string('phone', 50)->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->string('ip_address', 50)->nullable();
                $table->string('status', 30)->default('unread');
                $table->timestamps();

                $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_inquiries');
    }
};
