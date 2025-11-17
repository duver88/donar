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
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('admin_notes');
            $table->foreignId('updated_by_admin')->nullable()->constrained('users')->after('completed_at');

            // Agregar también campos que podrían estar faltando
            $table->string('patient_species', 50)->nullable()->after('patient_name');
            $table->string('patient_age', 20)->nullable()->after('patient_species');
            $table->string('blood_type', 20)->nullable()->after('patient_weight');
            $table->string('quantity_needed', 100)->nullable()->after('blood_type');
            $table->text('additional_notes')->nullable()->after('medical_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->dropForeign(['updated_by_admin']);
            $table->dropColumn([
                'admin_notes',
                'completed_at',
                'updated_by_admin',
                'patient_species',
                'patient_age',
                'blood_type',
                'quantity_needed',
                'additional_notes'
            ]);
        });
    }
};
