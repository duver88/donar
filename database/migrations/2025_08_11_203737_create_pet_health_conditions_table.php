<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pet_health_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->boolean('has_diagnosed_disease')->default(false);
            $table->boolean('under_medical_treatment')->default(false);
            $table->boolean('recent_surgery')->default(false);
            $table->json('diseases')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_health_conditions');
    }
};