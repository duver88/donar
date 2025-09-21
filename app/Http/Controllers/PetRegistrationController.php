<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use App\Models\PetHealthCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\PetApprovedWelcomeMail;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PetRegistrationController extends Controller
{
    public function create()
    {
        return view('pets.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'tutor_name' => 'required|string|max:255',
        'tutor_email' => 'required|email|unique:users,email',
        'tutor_document' => 'required|string|unique:users,document_id',
        'tutor_phone' => 'required|string',
        'pet_name' => 'required|string|max:255',
        'pet_breed' => 'required|string|max:255',
        'pet_species' => 'required|in:perro,gato',
        'pet_age' => 'required|integer|min:1|max:20',
        'pet_weight' => 'required|numeric|min:1',
        'pet_health_status' => 'required|in:excelente,bueno,regular,malo',
        'vaccines_up_to_date' => 'required|boolean',
        'has_donated_before' => 'required|boolean',
        'has_diagnosed_disease' => 'required|boolean',
        'under_medical_treatment' => 'required|boolean',
        'recent_surgery' => 'required|boolean',
        'diseases' => 'array',
        'pet_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    // Validar elegibilidad de la mascota
    $rejectionReasons = $this->validatePetEligibility($validated);
    
    if (!empty($rejectionReasons)) {
        return back()->withErrors([
            'pet_eligibility' => 'Tu mascota no es apta para donar por los siguientes motivos: ' . 
            implode(', ', $rejectionReasons)
        ])->withInput();
    }

    // Crear usuario tutor
    $tutor = User::create([
        'name' => $validated['tutor_name'],
        'email' => $validated['tutor_email'],
        'phone' => $validated['tutor_phone'],
        'document_id' => $validated['tutor_document'],
        'role' => 'tutor',
        'status' => 'approved',
        'password' => Hash::make('temp_password_' . rand(1000, 9999)),
        'email_verified_at' => now()
    ]);

    // Subir foto
    $photoPath = $request->file('pet_photo')->store('pet_photos', 'public');

    // Crear mascota
    $pet = Pet::create([
        'tutor_id' => $tutor->id,
        'name' => $validated['pet_name'],
        'breed' => $validated['pet_breed'],
        'species' => $validated['pet_species'],
        'age_years' => $validated['pet_age'],
        'weight_kg' => $validated['pet_weight'],
        'health_status' => $validated['pet_health_status'],
        'vaccines_up_to_date' => $validated['vaccines_up_to_date'],
        'has_donated_before' => $validated['has_donated_before'],
        'photo_path' => $photoPath,
        'donor_status' => 'approved', // Auto-aprobado si pasa validaciones
        'approved_at' => now()
    ]);

    // Crear registro de condiciones de salud
    PetHealthCondition::create([
        'pet_id' => $pet->id,
        'has_diagnosed_disease' => $validated['has_diagnosed_disease'],
        'under_medical_treatment' => $validated['under_medical_treatment'],
        'recent_surgery' => $validated['recent_surgery'],
        'diseases' => $validated['diseases'] ?? []
    ]);

    // ← ENVIAR EMAIL DE BIENVENIDA
    try {
        Mail::to($tutor->email)->send(new PetApprovedWelcomeMail($pet));
        
        // Registrar email enviado
        if (class_exists('\App\Models\EmailLog')) {
            EmailLog::create([
                'to_email' => $tutor->email,
                'to_name' => $tutor->name,
                'subject' => '¡Bienvenido! ' . $pet->name . ' ya es un héroe donante',
                'mailable_class' => 'PetApprovedWelcomeMail',
                'data' => [
                    'pet_id' => $pet->id,
                    'tutor_id' => $tutor->id
                ],
                'status' => 'sent',
                'sent_at' => now()
            ]);
        }
        
        $emailMessage = ' Se ha enviado un email de bienvenida con información sobre solicitudes urgentes.';
        
    } catch (\Exception $e) {
        Log::error('Error enviando email de bienvenida: ' . $e->getMessage());
        $emailMessage = ' (El email de bienvenida no pudo ser enviado)';
    }

    return redirect()->route('home')->with('success', 
        '¡Felicidades! Tu mascota ' . $pet->name . ' ha sido aprobada como donante.' . $emailMessage);
}

    private function validatePetEligibility($data)
    {
        $rejectionReasons = [];
        
        if ($data['has_diagnosed_disease']) {
            $rejectionReasons[] = "tiene enfermedad diagnosticada";
        }
        
        if ($data['under_medical_treatment']) {
            $rejectionReasons[] = "está bajo tratamiento médico";
        }
        
        if ($data['recent_surgery']) {
            $rejectionReasons[] = "tuvo cirugía reciente";
        }
        
        if (!empty($data['diseases'])) {
            $rejectionReasons[] = "tiene enfermedades: " . implode(', ', $data['diseases']);
        }
        
        if (!$data['vaccines_up_to_date']) {
            $rejectionReasons[] = "no tiene vacunas al día";
        }
        
        if ($data['pet_weight'] < 25) {
            $rejectionReasons[] = "peso insuficiente (mínimo 25kg)";
        }

        if ($data['pet_health_status'] === 'malo') {
            $rejectionReasons[] = "estado de salud malo";
        }
        
        return $rejectionReasons;
    }
}