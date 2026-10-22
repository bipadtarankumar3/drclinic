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
        if (!Schema::hasTable('clinic_services')) {
            Schema::create('clinic_services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('icon')->default('fa-stethoscope');
                $table->string('image')->nullable();
                $table->decimal('price', 10, 2)->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->index(['clinic_id', 'status', 'sort_order']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_services');
    }
};
