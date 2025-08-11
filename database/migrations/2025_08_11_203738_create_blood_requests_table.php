<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veterinarian_id')->constrained('users');
            $table->string('patient_name');
            $table->string('patient_breed');
            $table->decimal('patient_weight', 5, 2);
            $table->enum('blood_type_needed', ['DEA 1.1+', 'DEA 1.1-', 'Universal']);
            $table->enum('urgency_level', ['baja', 'media', 'alta', 'critica']);
            $table->text('medical_reason');
            $table->string('clinic_contact');
            $table->datetime('needed_by_date');
            $table->enum('status', ['active', 'fulfilled', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};