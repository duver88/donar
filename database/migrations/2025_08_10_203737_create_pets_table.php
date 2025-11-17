<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('breed');
            $table->enum('species', ['perro', 'gato']);
            $table->integer('age_years');
            $table->decimal('weight_kg', 5, 2);
            $table->enum('health_status', ['excelente', 'bueno', 'regular', 'malo']);
            $table->boolean('vaccines_up_to_date');
            $table->boolean('has_donated_before')->default(false);
            $table->string('photo_path');
            $table->enum('donor_status', ['pending', 'approved', 'rejected', 'inactive'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};