<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Pet;
use App\Models\EmailLog;
use App\Mail\BloodDonationRequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class BloodRequestController extends Controller
{
    public function create()
    {
        // Verificar que el veterinario esté aprobado
        if (Auth::user()->status !== 'approved') {
            return redirect()->route('veterinarian.dashboard')
                ->with('error', 'Tu cuenta debe estar aprobada para crear solicitudes.');
        }

        return view('blood-requests.create');
    }

    public function store(Request $request)
    {
        // Verificar que el veterinario esté aprobado
        if (Auth::user()->status !== 'approved') {
            return redirect()->route('veterinarian.dashboard')
                ->with('error', 'Tu cuenta debe estar aprobada para crear solicitudes.');
        }

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
            'veterinarian_id' => Auth::id(),
            'status' => 'active'
        ]));

        // Encontrar donantes compatibles (perros aprobados, peso mínimo 25kg)
        $compatibleDonors = Pet::where('donor_status', 'approved')
            ->where('species', 'perro')
            ->where('weight_kg', '>=', 25)
            ->with('tutor')
            ->get();

        // Enviar emails a los tutores de donantes
        $emailCount = 0;
        $failedEmails = 0;

        foreach ($compatibleDonors as $donor) {
            try {
                Mail::to($donor->tutor->email)
                    ->send(new BloodDonationRequestMail($bloodRequest, $donor));
                
                // Registrar email exitoso
                EmailLog::create([
                    'to_email' => $donor->tutor->email,
                    'to_name' => $donor->tutor->name,
                    'subject' => 'Solicitud Urgente de Donación de Sangre para ' . $bloodRequest->patient_name,
                    'mailable_class' => 'BloodDonationRequestMail',
                    'data' => [
                        'blood_request_id' => $bloodRequest->id,
                        'pet_id' => $donor->id,
                        'tutor_id' => $donor->tutor->id
                    ],
                    'status' => 'sent',
                    'sent_at' => now()
                ]);
                
                $emailCount++;
                
            } catch (\Exception $e) {
                // Registrar error de email
                EmailLog::create([
                    'to_email' => $donor->tutor->email,
                    'to_name' => $donor->tutor->name,
                    'subject' => 'Solicitud Urgente de Donación de Sangre para ' . $bloodRequest->patient_name,
                    'mailable_class' => 'BloodDonationRequestMail',
                    'data' => [
                        'blood_request_id' => $bloodRequest->id,
                        'pet_id' => $donor->id,
                        'tutor_id' => $donor->tutor->id
                    ],
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => now()
                ]);
                
                $failedEmails++;
                Log::error('Error enviando email de donación: ' . $e->getMessage());
            }
        }

        $message = "Solicitud de donación creada exitosamente. Se ha notificado a {$emailCount} posibles donantes.";
        if ($failedEmails > 0) {
            $message .= " ({$failedEmails} emails fallaron)";
        }

        return redirect()->route('veterinarian.dashboard')->with('success', $message);
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