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
            // Modificar la columna status para que sea más larga
            $table->string('status', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            // Revertir a tamaño original (asumiendo que era más pequeño)
            $table->string('status', 20)->change();
        });
    }
};
