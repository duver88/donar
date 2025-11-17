<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodRequest;
use App\Models\DonationResponse;
use App\Models\Pet;
use App\Mail\DonationAcceptedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DonationResponseController extends Controller
{
    /**
     * Acepta una solicitud de donación
     */
    public function accept(Request $request, BloodRequest $bloodRequest)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'message' => 'nullable|string|max:500'
        ]);
        
        $pet = Pet::findOrFail($validated['pet_id']);
        
        // Verificar que el usuario es el dueño de la mascota
        if ($pet->user_id !== Auth::id()) {
            abort(403, 'No tienes autorización para esta acción.');
        }
        
        // Verificar que la solicitud está activa
        if ($bloodRequest->status !== 'active') {
            return back()->with('warning', 'Esta solicitud ya no está activa.');
        }
        
        // Verificar que la mascota es compatible
        if ($pet->blood_type !== $bloodRequest->blood_type) {
            return back()->with('error', 'El tipo de sangre no es compatible.');
        }
        
        // Verificar que no ha respondido antes
        $existingResponse = DonationResponse::where('blood_request_id', $bloodRequest->id)
            ->where('pet_id', $pet->id)
            ->first();
            
        if ($existingResponse) {
            $responseType = $existingResponse->response_type === 'accepted' ? 'aceptado' : 'rechazado';
            return back()->with('warning', 'Ya has ' . $responseType . ' esta solicitud anteriormente.');
        }
        
        try {
            // Crear la respuesta de donación
            $donationResponse = DonationResponse::create([
                'blood_request_id' => $bloodRequest->id,
                'pet_id' => $pet->id,
                'user_id' => Auth::id(),
                'response_type' => 'accepted',
                'message' => $validated['message'],
                'responded_at' => now()
            ]);
            
            // Enviar email al veterinario
            Mail::to($bloodRequest->veterinarian->email)->send(
                new DonationAcceptedMail($bloodRequest, $pet, $donationResponse)
            );
            
            Log::info('Donación aceptada', [
                'blood_request_id' => $bloodRequest->id,
                'pet_id' => $pet->id,
                'user_id' => Auth::id(),
                'veterinarian_email' => $bloodRequest->veterinarian->email
            ]);
            
            return back()->with('success', '¡Gracias! Tu respuesta ha sido enviada al veterinario. ' .
                $bloodRequest->veterinarian->name . ' se pondrá en contacto contigo pronto para coordinar la donación.');
            
        } catch (\Exception $e) {
            Log::error('Error al aceptar donación', [
                'blood_request_id' => $bloodRequest->id,
                'pet_id' => $pet->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Hubo un error al procesar tu respuesta. Inténtalo de nuevo.');
        }
    }
    
    /**
     * Rechaza una solicitud de donación
     */
    public function decline(Request $request, BloodRequest $bloodRequest)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'decline_reason' => 'nullable|string|max:100'
        ]);
        
        $pet = Pet::findOrFail($validated['pet_id']);
        
        // Verificar que el usuario es el dueño de la mascota
        if ($pet->user_id !== Auth::id()) {
            abort(403, 'No tienes autorización para esta acción.');
        }
        
        // Verificar que la solicitud está activa
        if ($bloodRequest->status !== 'active') {
            return back()->with('warning', 'Esta solicitud ya no está activa.');
        }
        
        // Verificar que no ha respondido antes
        $existingResponse = DonationResponse::where('blood_request_id', $bloodRequest->id)
            ->where('pet_id', $pet->id)
            ->first();
            
        if ($existingResponse) {
            $responseType = $existingResponse->response_type === 'accepted' ? 'aceptado' : 'rechazado';
            return back()->with('warning', 'Ya has ' . $responseType . ' esta solicitud anteriormente.');
        }
        
        try {
            // Crear la respuesta de rechazo
            $donationResponse = DonationResponse::create([
                'blood_request_id' => $bloodRequest->id,
                'pet_id' => $pet->id,
                'user_id' => Auth::id(),
                'response_type' => 'declined',
                'decline_reason' => $validated['decline_reason'],
                'responded_at' => now()
            ]);
            
            Log::info('Donación rechazada', [
                'blood_request_id' => $bloodRequest->id,
                'pet_id' => $pet->id,
                'user_id' => Auth::id(),
                'reason' => $validated['decline_reason']
            ]);
            
            return back()->with('info', 'Entendemos que no puedas ayudar en este momento. Gracias por responder.');
            
        } catch (\Exception $e) {
            Log::error('Error al rechazar donación', [
                'blood_request_id' => $bloodRequest->id,
                'pet_id' => $pet->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Hubo un error al procesar tu respuesta. Inténtalo de nuevo.');
        }
    }
    
    /**
     * Muestra el historial de respuestas de donación del usuario
     */
    public function myResponses()
    {
        $responses = DonationResponse::where('user_id', Auth::id())
            ->with(['bloodRequest.veterinarian.veterinarian', 'pet'])
            ->orderBy('responded_at', 'desc')
            ->paginate(10);
            
        return view('donation-responses.index', compact('responses'));
    }
    
    /**
     * Marca una donación como completada (solo para veterinarios)
     */
    public function markCompleted(Request $request, DonationResponse $donationResponse)
    {
        // Verificar que el usuario es el veterinario de la solicitud
        $bloodRequest = $donationResponse->bloodRequest;
        if ($bloodRequest->veterinarian_id !== Auth::id()) {
            abort(403, 'No tienes autorización para esta acción.');
        }
        
        $validated = $request->validate([
            'completion_notes' => 'nullable|string|max:500'
        ]);
        
        try {
            $donationResponse->update([
                'donation_completed_at' => now(),
                'completion_notes' => $validated['completion_notes']
            ]);
            
            Log::info('Donación marcada como completada', [
                'donation_response_id' => $donationResponse->id,
                'blood_request_id' => $bloodRequest->id,
                'veterinarian_id' => Auth::id()
            ]);
            
            return back()->with('success', 'Donación marcada como completada exitosamente.');
            
        } catch (\Exception $e) {
            Log::error('Error marcando donación como completada', [
                'donation_response_id' => $donationResponse->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Hubo un error al marcar la donación como completada.');
        }
    }
}