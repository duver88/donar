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

        $recentRequests = BloodRequest::with(['veterinarian'])
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
    // Métodos simplificados que retornan al dashboard por ahora
    public function veterinarians()
    {
        return redirect()->route('admin.dashboard')->with('info', 'Vista de veterinarios en desarrollo');
    }

    public function pets()
    {
        return redirect()->route('admin.dashboard')->with('info', 'Vista de mascotas en desarrollo');
    }

    public function bloodRequests()
    {
        return redirect()->route('admin.dashboard')->with('info', 'Vista de solicitudes en desarrollo');
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