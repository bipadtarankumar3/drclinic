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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('sex')->nullable();
            $table->string('age')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('alternate_mobile_no')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('address')->nullable();
            $table->text('patient_problem')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
