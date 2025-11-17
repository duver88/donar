<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Veterinarian;
use App\Models\Pet;
use App\Models\PetHealthCondition;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ========================================
        // CREAR SUPER ADMIN
        // ========================================
        
        $admin = User::create([
            'name' => 'Super Administrador',
            'email' => 'admin@bancocanino.com',
            'phone' => '+57 300 123 4567',
            'document_id' => '12345678',
            'role' => 'super_admin',
            'status' => 'approved',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'approved_at' => now(),
        ]);

        // ========================================
        // CREAR VETERINARIO DE PRUEBA
        // ========================================
        
        $vet1 = User::create([
            'name' => 'Dr. Carlos Veterinario',
            'email' => 'carlos@veterinaria.com',
            'phone' => '+57 301 123 4567',
            'document_id' => '87654321',
            'role' => 'veterinarian',
            'status' => 'approved',
            'password' => Hash::make('vet123'),
            'email_verified_at' => now(),
            'approved_at' => now(),
            'approved_by' => $admin->id,
        ]);

        Veterinarian::create([
            'user_id' => $vet1->id,
            'professional_card' => 'VET-001-2024',
            'specialty' => 'Medicina Interna',
            'clinic_name' => 'Clínica Veterinaria San José',
            'clinic_address' => 'Calle 100 #15-30',
            'city' => 'Bogotá',
            'approved_at' => now(),
            'approved_by' => $admin->id,
        ]);

        // ========================================
        // CREAR VETERINARIO PENDIENTE
        // ========================================
        
        $vet2 = User::create([
            'name' => 'Dra. Ana Rodríguez',
            'email' => 'ana@clinicapet.com',
            'phone' => '+57 302 123 4567',
            'document_id' => '11223344',
            'role' => 'veterinarian',
            'status' => 'pending',
            'password' => Hash::make('vet456'),
            'email_verified_at' => now(),
        ]);

        Veterinarian::create([
            'user_id' => $vet2->id,
            'professional_card' => 'VET-002-2024',
            'specialty' => 'Cirugía',
            'clinic_name' => 'Clínica Pet Care',
            'clinic_address' => 'Carrera 50 #25-80',
            'city' => 'Medellín',
        ]);

        // ========================================
        // CREAR TUTORES Y MASCOTAS
        // ========================================
        
        $tutor1 = User::create([
            'name' => 'María García',
            'email' => 'maria@gmail.com',
            'phone' => '+57 310 123 4567',
            'document_id' => '55667788',
            'role' => 'tutor',
            'status' => 'approved',
            'password' => Hash::make('tutor123'),
            'email_verified_at' => now(),
        ]);

        $pet1 = Pet::create([
            'tutor_id' => $tutor1->id,
            'name' => 'Max',
            'breed' => 'Golden Retriever',
            'species' => 'perro',
            'age_years' => 3,
            'weight_kg' => 30.5,
            'health_status' => 'excelente',
            'vaccines_up_to_date' => true,
            'has_donated_before' => false,
            'photo_path' => 'pet_photos/default.jpg',
            'donor_status' => 'approved',
            'approved_at' => now(),
        ]);

        PetHealthCondition::create([
            'pet_id' => $pet1->id,
            'has_diagnosed_disease' => false,
            'under_medical_treatment' => false,
            'recent_surgery' => false,
            'diseases' => null, // Cambiado a null
        ]);

        $tutor2 = User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@hotmail.com',
            'phone' => '+57 311 123 4567',
            'document_id' => '99887766',
            'role' => 'tutor',
            'status' => 'approved',
            'password' => Hash::make('tutor456'),
            'email_verified_at' => now(),
        ]);

        $pet2 = Pet::create([
            'tutor_id' => $tutor2->id,
            'name' => 'Luna',
            'breed' => 'Labrador',
            'species' => 'perro',
            'age_years' => 2,
            'weight_kg' => 28.0,
            'health_status' => 'excelente',
            'vaccines_up_to_date' => true,
            'has_donated_before' => true,
            'photo_path' => 'pet_photos/default.jpg',
            'donor_status' => 'approved',
            'approved_at' => now(),
        ]);

        PetHealthCondition::create([
            'pet_id' => $pet2->id,
            'has_diagnosed_disease' => false,
            'under_medical_treatment' => false,
            'recent_surgery' => false,
            'diseases' => null, // Cambiado a null
        ]);

        $tutor3 = User::create([
            'name' => 'Sofia Martínez',
            'email' => 'sofia@yahoo.com',
            'phone' => '+57 312 123 4567',
            'document_id' => '44556677',
            'role' => 'tutor',
            'status' => 'approved',
            'password' => Hash::make('tutor789'),
            'email_verified_at' => now(),
        ]);

        $pet3 = Pet::create([
            'tutor_id' => $tutor3->id,
            'name' => 'Rocky',
            'breed' => 'Pastor Alemán',
            'species' => 'perro',
            'age_years' => 4,
            'weight_kg' => 35.0,
            'health_status' => 'bueno',
            'vaccines_up_to_date' => true,
            'has_donated_before' => false,
            'photo_path' => 'pet_photos/default.jpg',
            'donor_status' => 'approved',
            'approved_at' => now(),
        ]);

        PetHealthCondition::create([
            'pet_id' => $pet3->id,
            'has_diagnosed_disease' => false,
            'under_medical_treatment' => false,
            'recent_surgery' => false,
            'diseases' => null, // Cambiado a null
        ]);

        $this->command->info('========================================');
        $this->command->info('DATOS DE PRUEBA CREADOS');
        $this->command->info('========================================');
        $this->command->info('SUPER ADMIN:');
        $this->command->info('Email: admin@bancocanino.com');
        $this->command->info('Password: admin123');
        $this->command->info('');
        $this->command->info('VETERINARIO APROBADO:');
        $this->command->info('Email: carlos@veterinaria.com');
        $this->command->info('Password: vet123');
        $this->command->info('');
        $this->command->info('VETERINARIO PENDIENTE:');
        $this->command->info('Email: ana@clinicapet.com');
        $this->command->info('Password: vet456');
        $this->command->info('');
        $this->command->info('TUTORES:');
        $this->command->info('Email: maria@gmail.com - Password: tutor123');
        $this->command->info('Email: juan@hotmail.com - Password: tutor456');
        $this->command->info('Email: sofia@yahoo.com - Password: tutor789');
        $this->command->info('========================================');
    }
}