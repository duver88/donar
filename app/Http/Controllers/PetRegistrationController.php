<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use App\Models\PetHealthCondition;
use App\Models\BloodRequest;                    // NUEVO
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\PetApprovedWelcomeMail;
use App\Mail\ActiveRequestsListMail;            // NUEVO
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;       // <-- IMPORTANTE

class PetRegistrationController extends Controller
{
    // Límite de solicitudes en el email antes de redirigir a web
    const MAX_REQUESTS_IN_EMAIL = 5;
    
    public function create()
    {
        return view('pets.create');
    }

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'user' => [
                    'name' => $user->name,
                    'document_id' => $user->document_id,
                    'phone' => $user->phone
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function store(Request $request)
    {
        // 1) Validación de formato/contenido (sin unique directo para permitir múltiples mascotas por tutor)
        $validated = $request->validate([
            'tutor_name'             => 'required|string|max:255',
            'tutor_email'            => 'required|email',
            'tutor_document'         => 'required|string',
            'tutor_phone'            => 'required|string',
            'pet_name'               => 'required|string|max:255',
            'pet_breed'              => 'required|string|max:255',
            'pet_species'            => 'required|in:perro,gato',
            'pet_age'                => 'required|integer|min:1|max:20',
            'pet_weight'             => 'required|numeric|min:1',
            'pet_blood_type'         => 'nullable|string|max:50',                     // NUEVO CAMPO
            'pet_health_status'      => 'required|in:excelente,bueno,regular,malo',
            'vaccines_up_to_date'    => 'required|boolean',
            'has_donated_before'     => 'required|boolean',
            'has_diagnosed_disease'  => 'required|boolean',
            'under_medical_treatment'=> 'required|boolean',
            'recent_surgery'         => 'required|boolean',
            'diseases'               => 'nullable|array',
            'pet_photo'              => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2) Validar elegibilidad de la mascota
        $rejectionReasons = $this->validatePetEligibility($validated);
        if (!empty($rejectionReasons)) {
            return back()->withErrors([
                'pet_eligibility' => 'Tu mascota no es apta para donar por los siguientes motivos: ' . 
                implode(', ', $rejectionReasons)
            ])->withInput();
        }

        try {
            // 3) Verificar si es usuario existente
            $existingUser = User::where('email', $validated['tutor_email'])->first();
            $isNewUser = !$existingUser;

            // 4) Obtener o crear tutor (sin chocar con unique si ya existe)
            $tutor = $this->findOrCreateTutor($validated);

            // 5) Subir foto
            $photoPath = $request->file('pet_photo')->store('pet_photos', 'public');

            // 6) Crear mascota
            $pet = Pet::create([
                'tutor_id' => $tutor->id,
                'user_id' => $tutor->id,                                // AGREGADO para compatibilidad
                'name' => $validated['pet_name'],
                'breed' => $validated['pet_breed'],
                'species' => $validated['pet_species'],
                'age_years' => $validated['pet_age'],
                'age' => $validated['pet_age'],                         // AGREGADO para compatibilidad
                'weight_kg' => $validated['pet_weight'],
                'weight' => $validated['pet_weight'],                   // AGREGADO para compatibilidad
                'blood_type' => $validated['pet_blood_type'] ?? 'No determinado', // NUEVO
                'health_status' => $validated['pet_health_status'],
                'vaccines_up_to_date' => $validated['vaccines_up_to_date'],
                'vaccination_status' => $validated['vaccines_up_to_date'], // AGREGADO para compatibilidad
                'has_donated_before' => $validated['has_donated_before'],
                'photo_path' => $photoPath,
                'donor_status' => 'approved',
                'status' => 'approved',                                 // AGREGADO para compatibilidad
                'approved_at' => now()
            ]);

            // 7) Crear registro de condiciones de salud
            PetHealthCondition::create([
                'pet_id' => $pet->id,
                'has_diagnosed_disease' => $validated['has_diagnosed_disease'],
                'under_medical_treatment' => $validated['under_medical_treatment'],
                'recent_surgery' => $validated['recent_surgery'],
                'diseases' => $validated['diseases'] ?? []
            ]);

            Log::info('Nueva mascota registrada', [
                'pet_id' => $pet->id,
                'tutor_id' => $tutor->id,
                'name' => $pet->name,
                'is_new_user' => $isNewUser
            ]);

            // 8) ENVIAR EMAIL DIFERENCIADO
            $this->sendDifferentiatedEmail($pet, $tutor, $isNewUser);

            // 9) BUSCAR SOLICITUDES ACTIVAS COMPATIBLES (NUEVO)
            $activeRequests = $this->getCompatibleActiveRequests($pet);

            // 10) ENVIAR EMAIL DE SOLICITUDES ACTIVAS (NUEVO)
            if ($activeRequests->count() > 0) {
                $this->scheduleActiveRequestsEmail($pet, $activeRequests);
            }

            $emailMessage = $isNewUser
                ? ' Se ha enviado un email de bienvenida con información sobre solicitudes urgentes.'
                : ' Se ha enviado un email confirmando el registro de tu nueva mascota.';

            return redirect()->route('home')->with('success',
                '¡Felicidades! Tu mascota ' . $pet->name . ' ha sido aprobada como donante.' . $emailMessage);

        } catch (\Exception $e) {
            Log::error('Error registrando mascota', [
                'error' => $e->getMessage(),
                'data' => $validated
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Hubo un error al registrar la mascota. Inténtalo de nuevo.');
        }
    }

    /**
     * Encuentra o crea el tutor de forma flexible para formulario público.
     * Permite múltiples mascotas por persona usando el email como identificador principal.
     */
    private function findOrCreateTutor(array $validated): User
    {
        // Primero buscar por email (identificador principal)
        $tutor = User::where('email', $validated['tutor_email'])->first();

        if ($tutor) {
            // Usuario encontrado por email - actualizar datos si es necesario
            $updated = false;

            if (empty($tutor->name) || $tutor->name !== $validated['tutor_name']) {
                $tutor->name = $validated['tutor_name'];
                $updated = true;
            }

            if (empty($tutor->phone) || $tutor->phone !== $validated['tutor_phone']) {
                $tutor->phone = $validated['tutor_phone'];
                $updated = true;
            }


            // Actualizar documento si estaba vacío
            if (empty($tutor->document_id) && !empty($validated['tutor_document'])) {
                $tutor->document_id = $validated['tutor_document'];
                $updated = true;
            }

            // Asegurar rol y estado correcto
            if ($tutor->role !== 'tutor') {
                $tutor->role = 'tutor';
                $updated = true;
            }

            if ($tutor->status !== 'approved') {
                $tutor->status = 'approved';
                $updated = true;
            }

            if (!$tutor->email_verified_at) {
                $tutor->email_verified_at = now();
                $updated = true;
            }

            if ($updated) {
                $tutor->save();
            }

            return $tutor;
        }

        // Si no existe por email, verificar si existe por documento
        if (!empty($validated['tutor_document'])) {
            $tutorByDocument = User::where('document_id', $validated['tutor_document'])->first();

            if ($tutorByDocument) {
                // Actualizar email si es diferente
                $tutorByDocument->email = $validated['tutor_email'];
                $tutorByDocument->name = $validated['tutor_name'];
                $tutorByDocument->phone = $validated['tutor_phone'];
                $tutorByDocument->role = 'tutor';
                $tutorByDocument->status = 'approved';

                if (!$tutorByDocument->email_verified_at) {
                    $tutorByDocument->email_verified_at = now();
                }

                $tutorByDocument->save();
                return $tutorByDocument;
            }
        }

        // No existe - crear nuevo usuario
        try {
            return User::create([
                'name'              => $validated['tutor_name'],
                'email'             => $validated['tutor_email'],
                'phone'             => $validated['tutor_phone'],
                'document_id'       => $validated['tutor_document'],
                'role'              => 'tutor',
                'status'            => 'approved',
                'password'          => Hash::make('temp_password_' . random_int(1000, 9999)),
                'email_verified_at' => now(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Si falla por constrains de unique, intentar buscar nuevamente
            $existingUser = User::where('email', $validated['tutor_email'])
                                ->orWhere('document_id', $validated['tutor_document'])
                                ->first();

            if ($existingUser) {
                // Actualizar y retornar usuario existente
                $existingUser->update([
                    'name' => $validated['tutor_name'],
                    'phone' => $validated['tutor_phone'],
                    'role' => 'tutor',
                    'status' => 'approved'
                ]);
                return $existingUser;
            }

            // Si sigue fallando, lanzar la excepción original
            throw $e;
        }
    }

    /**
     * Envía el email diferenciado según si es usuario nuevo o existente
     */
    private function sendDifferentiatedEmail($pet, $tutor, $isNewUser)
    {
        try {
            if ($isNewUser) {
                // Usuario nuevo - enviar email de bienvenida
                Mail::to($tutor->email)->send(new PetApprovedWelcomeMail($pet));

                $subject = '¡Bienvenido! ' . $pet->name . ' ya es un héroe donante';
                $mailableClass = 'PetApprovedWelcomeMail';
                $logMessage = 'Email de bienvenida enviado';
            } else {
                // Usuario existente - enviar email de nueva mascota
                Mail::to($tutor->email)->send(new \App\Mail\NewPetRegisteredMail($pet, $tutor));

                $subject = 'Nueva mascota registrada: ' . $pet->name;
                $mailableClass = 'NewPetRegisteredMail';
                $logMessage = 'Email de nueva mascota enviado';
            }

            // Registrar email enviado
            if (class_exists('\App\Models\EmailLog')) {
                EmailLog::create([
                    'to_email' => $tutor->email,
                    'to_name' => $tutor->name,
                    'subject' => $subject,
                    'mailable_class' => $mailableClass,
                    'data' => [
                        'pet_id' => $pet->id,
                        'tutor_id' => $tutor->id,
                        'is_new_user' => $isNewUser
                    ],
                    'status' => 'sent',
                    'sent_at' => now()
                ]);
            }

            Log::info($logMessage, [
                'pet_id' => $pet->id,
                'email' => $tutor->email,
                'is_new_user' => $isNewUser
            ]);

        } catch (\Exception $e) {
            Log::error('Error enviando email: ' . $e->getMessage(), [
                'pet_id' => $pet->id,
                'is_new_user' => $isNewUser
            ]);
        }
    }

    /**
     * Obtiene solicitudes activas compatibles (NUEVO)
     */
    private function getCompatibleActiveRequests($pet)
    {
        $bloodType = $pet->blood_type ?? '';

        // Solo buscar si tiene tipo de sangre definido
        if (empty($bloodType) || $bloodType === 'No determinado') {
            return collect([]);
        }

        return BloodRequest::where('status', 'active')
            ->where('blood_type', $bloodType)
            ->where('created_at', '<', $pet->created_at)
            ->with(['veterinarian.user'])
            ->orderBy('urgency_level', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Programa el envío del email de solicitudes activas (NUEVO)
     */
    private function scheduleActiveRequestsEmail($pet, $activeRequests)
    {
        try {
            // Delay de 30 segundos para separar los emails
            sleep(30);
            $this->sendActiveRequestsEmail($pet, $activeRequests);
            
        } catch (\Exception $e) {
            Log::error('Error programando email de solicitudes activas', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envía el email de solicitudes activas (NUEVO)
     */
    private function sendActiveRequestsEmail($pet, $activeRequests)
    {
        try {
            Mail::to($pet->user->email)->send(
                new ActiveRequestsListMail($pet, $activeRequests)
            );
            
            // Registrar email enviado
            if (class_exists('\App\Models\EmailLog')) {
                EmailLog::create([
                    'to_email' => $pet->user->email,
                    'to_name' => $pet->user->name,
                    'subject' => "🩸 {$activeRequests->count()} casos activos necesitan donación de sangre tipo {$pet->blood_type}",
                    'mailable_class' => 'ActiveRequestsListMail',
                    'data' => [
                        'pet_id' => $pet->id,
                        'requests_count' => $activeRequests->count()
                    ],
                    'status' => 'sent',
                    'sent_at' => now()
                ]);
            }
            
            Log::info('Email de solicitudes activas enviado', [
                'pet_id' => $pet->id,
                'email' => $pet->user->email,
                'requests_count' => $activeRequests->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error enviando email de solicitudes activas', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage()
            ]);
        }
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

    /**
     * MÉTODOS ADICIONALES PARA COMPATIBILIDAD CON NUEVAS RUTAS
     */

    public function index()
    {
        // Redirigir a home si no está implementada la vista
        return redirect()->route('home')->with('info', 'Funcionalidad en desarrollo.');
    }

    public function show(Pet $pet)
    {
        // Redirigir a home si no está implementada la vista
        return redirect()->route('home')->with('info', 'Funcionalidad en desarrollo.');
    }

    public function edit(Pet $pet)
    {
        // Redirigir a home si no está implementada la vista
        return redirect()->route('home')->with('info', 'Funcionalidad en desarrollo.');
    }

    public function update(Request $request, Pet $pet)
    {
        // Redirigir a home si no está implementada la vista
        return redirect()->route('home')->with('info', 'Funcionalidad en desarrollo.');
    }
}
