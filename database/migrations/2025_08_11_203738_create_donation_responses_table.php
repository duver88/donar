<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blood_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('pet_id')->constrained();
            $table->foreignId('tutor_id')->constrained('users');
            $table->enum('response', ['interested', 'not_available', 'completed']);
            $table->text('notes')->nullable();
            $table->timestamp('responded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_responses');
    }
};