<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veterinarian;
use App\Models\BloodRequest;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class VeterinarianController extends Controller
{
    public function register()
    {
        return view('veterinarians.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'document_id' => 'required|string|unique:users,document_id',
            'professional_card' => 'required|string|unique:veterinarians,professional_card',
            'professional_card_photo' => 'required|image|mimes:jpeg,png,jpg,pdf|max:15120', // ← NUEVA VALIDACIÓN
            'specialty' => 'nullable|string',
            'clinic_name' => 'required|string',
            'clinic_address' => 'required|string',
            'city' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Crear usuario veterinario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'document_id' => $validated['document_id'],
            'role' => 'veterinarian',
            'status' => 'pending',
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now()
        ]);

        // ← NUEVA LÓGICA PARA SUBIR FOTO
        $photoPath = null;
        if ($request->hasFile('professional_card_photo')) {
            $photoPath = $request->file('professional_card_photo')
                ->store('professional_cards', 'public');
        }

        // Crear perfil de veterinario
        Veterinarian::create([
            'user_id' => $user->id,
            'professional_card' => $validated['professional_card'],
            'professional_card_photo' => $photoPath, // ← AGREGAR ESTE CAMPO
            'specialty' => $validated['specialty'],
            'clinic_name' => $validated['clinic_name'],
            'clinic_address' => $validated['clinic_address'],
            'city' => $validated['city']
        ]);

        return redirect()->route('login')->with('success', 
            'Registro exitoso. Tu solicitud está en revisión por el administrador.');
    }

    public function dashboard()
    {
        // Verificar que el usuario esté autenticado y sea veterinario
        if (!Auth::check() || Auth::user()->role !== 'veterinarian') {
            return redirect()->route('home');
        }

        $user = Auth::user();
        
        $stats = [
            'my_requests' => BloodRequest::where('veterinarian_id', $user->id)->count(),
            'active_requests' => BloodRequest::where('veterinarian_id', $user->id)
                                            ->where('status', 'active')->count(),
            'available_donors' => Pet::where('donor_status', 'approved')
                                     ->where('species', 'perro')
                                     ->count()
        ];

        $myRequests = BloodRequest::where('veterinarian_id', $user->id)
                                 ->latest()
                                 ->get();

        return view('veterinarian.dashboard', compact('stats', 'myRequests'));
    }

    /**
     * Muestra los detalles de una solicitud específica del veterinario
     */
    public function showBloodRequest($id)
    {
        // Verificar que el usuario esté autenticado y sea veterinario
        if (!Auth::check() || Auth::user()->role !== 'veterinarian') {
            return redirect()->route('home');
        }

        // Buscar la solicitud y verificar que pertenezca al veterinario autenticado
        $request = BloodRequest::with(['donationResponses.pet.tutor'])
                              ->where('id', $id)
                              ->where('veterinarian_id', Auth::id())
                              ->firstOrFail();

        return view('veterinarian.blood-requests.show', compact('request'));
    }
}