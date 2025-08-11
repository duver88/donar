<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email');
            $table->string('document_id')->unique()->after('phone');
            $table->enum('role', ['super_admin', 'veterinarian', 'tutor'])->after('document_id');
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending')->after('role');
            $table->timestamp('approved_at')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'document_id', 'role', 'status', 'approved_at', 'approved_by']);
        });
    }
};