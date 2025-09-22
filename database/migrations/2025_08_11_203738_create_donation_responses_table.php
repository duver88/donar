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
        Schema::create('donation_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blood_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('response_type', ['accepted', 'declined']);
            $table->text('message')->nullable(); // Mensaje del tutor cuando acepta
            $table->string('decline_reason')->nullable(); // Razón cuando rechaza
            $table->timestamp('responded_at'); // Cuando respondió el tutor
            $table->timestamp('contacted_at')->nullable(); // Cuando el vet contactó al tutor
            $table->timestamp('donation_completed_at')->nullable(); // Cuando se completó la donación
            $table->text('completion_notes')->nullable(); // Notas del veterinario al completar
            $table->timestamps();
            
            // Evitar respuestas duplicadas de la misma mascota a la misma solicitud
            $table->unique(['blood_request_id', 'pet_id']);
            
            // Índices para optimizar consultas
            $table->index(['blood_request_id', 'response_type']);
            $table->index(['user_id', 'responded_at']);
            $table->index(['pet_id', 'response_type']);
            $table->index('donation_completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_responses');
    }
};