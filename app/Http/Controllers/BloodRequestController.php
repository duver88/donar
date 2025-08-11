<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Pet;
use App\Mail\BloodDonationRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BloodRequestController extends Controller
{
    public function create()
    {
        return view('blood-requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_breed' => 'required|string|max:255',
            'patient_weight' => 'required|numeric|min:1',
            'blood_type_needed' => 'required|in:DEA 1.1+,DEA 1.1-,Universal',
            'urgency_level' => 'required|in:baja,media,alta,critica',
            'medical_reason' => 'required|string',
            'clinic_contact' => 'required|string',
            'needed_by_date' => 'required|date|after:now'
        ]);

        // Crear solicitud de donación
        $bloodRequest = BloodRequest::create(array_merge($validated, [
            'veterinarian_id' => Auth::id()
        ]));

        // Encontrar donantes compatibles
        $compatibleDonors = Pet::where('donor_status', 'approved')
            ->where('species', 'perro')
            ->where('weight_kg', '>=', 25)
            ->with('tutor')
            ->get();

        // Enviar emails a los tutores de donantes
        $emailCount = 0;
        foreach ($compatibleDonors as $donor) {
            try {
                Mail::to($donor->tutor->email)
                    ->send(new BloodDonationRequestMail($bloodRequest, $donor));
                $emailCount++;
            } catch (\Exception $e) {
                // Log error but continue
                Log::error('Error enviando email: ' . $e->getMessage());
            }
        }

        return redirect()->route('veterinarian.dashboard')->with('success', 
            'Solicitud de donación creada exitosamente. Se ha notificado a ' . 
            $emailCount . ' posibles donantes.');
    }

    public function cancel($id)
    {
        $request = BloodRequest::where('id', $id)
                              ->where('veterinarian_id', Auth::id())
                              ->firstOrFail();
        
        $request->update(['status' => 'cancelled']);
        
        return response()->json(['success' => true]);
    }
}