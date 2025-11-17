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
        Schema::table('pets', function (Blueprint $table) {
            // Agregar campos de compatibilidad que se usan en el SuperAdminController
            $table->integer('age')->nullable()->after('age_years'); // compatibilidad con age_years
            $table->decimal('weight', 8, 2)->nullable()->after('weight_kg'); // compatibilidad con weight_kg
            $table->boolean('vaccination_status')->nullable()->after('vaccines_up_to_date'); // compatibilidad con vaccines_up_to_date
            $table->string('status', 50)->nullable()->after('donor_status'); // compatibilidad con donor_status
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['age', 'weight', 'vaccination_status', 'status']);
        });
    }
};
