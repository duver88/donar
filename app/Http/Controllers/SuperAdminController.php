<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pet;
use App\Models\BloodRequest;
use App\Mail\VeterinarianApprovedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'pending_veterinarians' => User::where('role', 'veterinarian')
                                          ->where('status', 'pending')->count(),
            'approved_veterinarians' => User::where('role', 'veterinarian')
                                           ->where('status', 'approved')->count(),
            'total_donors' => Pet::where('donor_status', 'approved')->count(),
            'pending_donors' => Pet::where('donor_status', 'pending')->count(),
            'active_requests' => BloodRequest::where('status', 'active')->count(),
            'total_tutors' => User::where('role', 'tutor')->count()
        ];

        $pendingVeterinarians = User::where('role', 'veterinarian')
                                   ->where('status', 'pending')
                                   ->with('veterinarian')
                                   ->latest()
                                   ->get();

        $recentRequests = BloodRequest::with(['veterinarian.user'])
                                     ->latest()
                                     ->take(10)
                                     ->get();

        return view('admin.dashboard', compact('stats', 'pendingVeterinarians', 'recentRequests'));
    }

public function approveVeterinarian($id)
{
    $user = User::findOrFail($id);
    
    if ($user->role !== 'veterinarian') {
        return redirect()->route('admin.dashboard')
                        ->with('error', 'Usuario no es veterinario');
    }

    $user->update([
        'status' => 'approved',
        'approved_at' => now(),
        'approved_by' => Auth::id()
    ]);

    $user->veterinarian->update([
        'approved_at' => now(),
        'approved_by' => Auth::id()
    ]);

    // Enviar email de aprobación
    try {
        Mail::to($user->email)->send(new VeterinarianApprovedMail($user));
        $emailStatus = 'Email de aprobación enviado exitosamente';
    } catch (\Exception $e) {
        Log::error('Error enviando email de aprobación: ' . $e->getMessage());
        $emailStatus = 'Veterinario aprobado pero hubo un error enviando el email';
    }

    return redirect()->route('admin.dashboard')
                    ->with('success', 'Veterinario aprobado exitosamente. ' . $emailStatus);
}

    public function rejectVeterinarian(Request $request, $id)
 {
    $request->validate([
        'rejection_reason' => 'required|string'
    ]);

    $user = User::findOrFail($id);
    
    if ($user->role !== 'veterinarian') {
        return redirect()->route('admin.dashboard')
                        ->with('error', 'Usuario no es veterinario');
    }

    $user->update(['status' => 'rejected']);
    
    $user->veterinarian->update([
        'rejection_reason' => $request->rejection_reason
    ]);

    // Aquí podrías enviar un email de rechazo también
    
    return redirect()->route('admin.dashboard')
                    ->with('success', 'Veterinario rechazado exitosamente');
}
    // ========================================
    // GESTIÓN DE VETERINARIOS
    // ========================================

    public function veterinarians(Request $request)
    {
        $query = User::where('role', 'veterinarian')->with('veterinarian');

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $veterinarians = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.veterinarians.index', compact('veterinarians'));
    }

    public function createVeterinarian()
    {
        return view('admin.veterinarians.create');
    }

    public function storeVeterinarian(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:50',
            'specialty' => 'nullable|string|max:100',
            'clinic_name' => 'required|string|max:255',
            'clinic_address' => 'required|string|max:500',
            'years_experience' => 'required|integer|min:0|max:50',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => 'veterinarian',
            'status' => $validated['status'],
            'password' => bcrypt('temp_password_' . random_int(1000, 9999)),
            'email_verified_at' => now(),
            'approved_at' => $validated['status'] === 'approved' ? now() : null,
            'approved_by' => $validated['status'] === 'approved' ? Auth::id() : null,
        ]);

        $user->veterinarian()->create([
            'license_number' => $validated['license_number'],
            'specialty' => $validated['specialty'],
            'clinic_name' => $validated['clinic_name'],
            'clinic_address' => $validated['clinic_address'],
            'years_experience' => $validated['years_experience'],
            'approved_at' => $validated['status'] === 'approved' ? now() : null,
            'approved_by' => $validated['status'] === 'approved' ? Auth::id() : null,
        ]);

        return redirect()->route('admin.veterinarians')
                        ->with('success', 'Veterinario creado exitosamente');
    }

    public function editVeterinarian($id)
    {
        $veterinarian = User::where('role', 'veterinarian')
                           ->with('veterinarian')
                           ->findOrFail($id);

        return view('admin.veterinarians.edit', compact('veterinarian'));
    }

    public function updateVeterinarian(Request $request, $id)
    {
        $veterinarian = User::where('role', 'veterinarian')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'document_id' => 'required|string|max:50',
            'professional_card' => 'required|string|max:50',
            'specialty' => 'nullable|string|max:100',
            'professional_card_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'clinic_name' => 'required|string|max:255',
            'clinic_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $oldStatus = $veterinarian->status;

        // Actualizar usuario
        $veterinarian->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'document_id' => $validated['document_id'],
            'status' => $validated['status'],
            'approved_at' => ($validated['status'] === 'approved' && $oldStatus !== 'approved') ? now() : $veterinarian->approved_at,
            'approved_by' => ($validated['status'] === 'approved' && $oldStatus !== 'approved') ? Auth::id() : $veterinarian->approved_by,
        ]);

        // Preparar datos del veterinario
        $veterinarianData = [
            'professional_card' => $validated['professional_card'],
            'specialty' => $validated['specialty'],
            'clinic_name' => $validated['clinic_name'],
            'clinic_address' => $validated['clinic_address'],
            'city' => $validated['city'],
            'approved_at' => ($validated['status'] === 'approved' && $oldStatus !== 'approved') ? now() : $veterinarian->veterinarian->approved_at,
            'approved_by' => ($validated['status'] === 'approved' && $oldStatus !== 'approved') ? Auth::id() : $veterinarian->veterinarian->approved_by,
        ];

        // Manejar foto de tarjeta profesional
        if ($request->hasFile('professional_card_photo')) {
            // Eliminar foto anterior si existe
            if ($veterinarian->veterinarian->professional_card_photo) {
                \Storage::disk('public')->delete($veterinarian->veterinarian->professional_card_photo);
            }

            $path = $request->file('professional_card_photo')->store('veterinarian_cards', 'public');
            $veterinarianData['professional_card_photo'] = $path;
        }

        $veterinarian->veterinarian->update($veterinarianData);

        return redirect()->route('admin.veterinarians')
                        ->with('success', 'Veterinario actualizado exitosamente');
    }

    public function destroyVeterinarian($id)
    {
        $veterinarian = User::where('role', 'veterinarian')->findOrFail($id);

        // Verificar si tiene solicitudes activas o pendientes (la clave foránea apunta a users.id directamente)
        $activeRequests = BloodRequest::where('veterinarian_id', $id)
                                     ->whereIn('status', ['active', 'pending'])
                                     ->count();

        if ($activeRequests > 0) {
            return redirect()->route('admin.veterinarians')
                            ->with('error', 'El veterinario tiene solicitudes activas o pendientes. No se puede eliminar un veterinario que tiene solicitudes de sangre en proceso.');
        }

        // Manejar todas las solicitudes de sangre asociadas
        $allRequests = BloodRequest::where('veterinarian_id', $id)->get();

        foreach ($allRequests as $request) {
            // Eliminar respuestas de donación asociadas a cada solicitud
            $request->donationResponses()->delete();
            // Eliminar la solicitud
            $request->delete();
        }

        // Eliminar foto de tarjeta profesional si existe
        if ($veterinarian->veterinarian && $veterinarian->veterinarian->professional_card_photo) {
            \Storage::disk('public')->delete($veterinarian->veterinarian->professional_card_photo);
        }

        // Eliminar registro del veterinario primero (si existe)
        if ($veterinarian->veterinarian) {
            $veterinarian->veterinarian->delete();
        }

        // Eliminar usuario
        $veterinarian->delete();

        return redirect()->route('admin.veterinarians')
                        ->with('success', 'Veterinario eliminado exitosamente');
    }

    public function showVeterinarian($id)
    {
        $veterinarian = User::where('role', 'veterinarian')
                           ->with(['veterinarian.bloodRequests'])
                           ->findOrFail($id);

        return view('admin.veterinarians.show', compact('veterinarian'));
    }

    // ========================================
    // GESTIÓN DE MASCOTAS
    // ========================================

    public function pets(Request $request)
    {
        $query = Pet::with(['user', 'healthConditions']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('donor_status', $request->status);
        }

        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $pets = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pets.index', compact('pets'));
    }

    public function showPet($id)
    {
        $pet = Pet::with(['user', 'healthConditions'])->findOrFail($id);

        return view('admin.pets.show', compact('pet'));
    }

    public function editPet($id)
    {
        $pet = Pet::with(['user', 'healthConditions'])->findOrFail($id);

        return view('admin.pets.edit', compact('pet'));
    }

    public function updatePet(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'species' => 'required|in:perro,gato',
            'age_years' => 'required|integer|min:1|max:20',
            'weight_kg' => 'required|numeric|min:1',
            'blood_type' => 'nullable|string|max:50',
            'health_status' => 'required|in:excelente,bueno,regular,malo',
            'vaccines_up_to_date' => 'required|boolean',
            'has_donated_before' => 'required|boolean',
            'donor_status' => 'required|in:pending,approved,rejected'
        ]);

        $pet->update([
            'name' => $validated['name'],
            'breed' => $validated['breed'],
            'species' => $validated['species'],
            'age_years' => $validated['age_years'],
            'age' => $validated['age_years'], // compatibilidad
            'weight_kg' => $validated['weight_kg'],
            'weight' => $validated['weight_kg'], // compatibilidad
            'blood_type' => $validated['blood_type'] ?? 'No determinado',
            'health_status' => $validated['health_status'],
            'vaccines_up_to_date' => $validated['vaccines_up_to_date'],
            'vaccination_status' => $validated['vaccines_up_to_date'], // compatibilidad
            'has_donated_before' => $validated['has_donated_before'],
            'donor_status' => $validated['donor_status'],
            'status' => $validated['donor_status'], // compatibilidad
            'approved_at' => $validated['donor_status'] === 'approved' ? now() : null
        ]);

        return redirect()->route('admin.pets')
                        ->with('success', 'Mascota actualizada exitosamente');
    }

    public function destroyPet($id)
    {
        $pet = Pet::findOrFail($id);

        // Eliminar foto si existe
        if ($pet->photo_path && \Storage::disk('public')->exists($pet->photo_path)) {
            \Storage::disk('public')->delete($pet->photo_path);
        }

        $pet->healthConditions()->delete();
        $pet->delete();

        return redirect()->route('admin.pets')
                        ->with('success', 'Mascota eliminada exitosamente');
    }

    // ========================================
    // GESTIÓN DE SOLICITUDES
    // ========================================

    public function bloodRequests(Request $request)
    {
        $query = BloodRequest::with(['veterinarian.user']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('urgency')) {
            $query->where('urgency_level', $request->urgency);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('blood_type', 'like', "%{$search}%")
                  ->orWhereHas('veterinarian.user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.blood-requests.index', compact('requests'));
    }

    public function showBloodRequest($id)
    {
        $request = BloodRequest::with(['veterinarian.user', 'donationResponses.pet.user'])->findOrFail($id);

        return view('admin.blood-requests.show', compact('request'));
    }

    public function updateBloodRequestStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,completed,cancelled,expired',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $bloodRequest = BloodRequest::findOrFail($id);
        $oldStatus = $bloodRequest->status;

        $bloodRequest->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'completed_at' => $validated['status'] === 'completed' ? now() : null,
            'updated_by_admin' => Auth::id()
        ]);

        // Crear registro en historial si el estado cambió
        if ($oldStatus !== $validated['status']) {
            \DB::table('blood_request_history')->insert([
                'blood_request_id' => $bloodRequest->id,
                'previous_status' => $oldStatus,
                'new_status' => $validated['status'],
                'changed_by' => Auth::id(),
                'change_reason' => $validated['admin_notes'] ?? 'Cambio desde panel administrativo',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('admin.blood_requests')
                        ->with('success', 'Estado de solicitud actualizado exitosamente');
    }

    public function reviewVeterinarian($id)
    {
        $veterinarian = User::where('role', 'veterinarian')
                        ->where('id', $id)
                        ->with('veterinarian')
                        ->firstOrFail();
                        
        if ($veterinarian->status !== 'pending') {
            return redirect()->route('admin.dashboard')
                            ->with('info', 'Este veterinario ya ha sido procesado.');
        }
        
        return view('admin.veterinarians.review', compact('veterinarian'));
    }


    public function handle()
{
    $veterinarian = User::where('role', 'veterinarian')->first();
    
    if ($veterinarian) {
        Mail::to('tu_email_de_prueba@gmail.com')
            ->send(new VeterinarianApprovedMail($veterinarian));
        
        $this->info('Email de prueba enviado exitosamente');
    } else {
        $this->error('No hay veterinarios en la base de datos para probar');
    }
}

// También actualiza los métodos approveVeterinarian y rejectVeterinarian
// para que redirijan al dashboard en lugar de retornar JSON
}