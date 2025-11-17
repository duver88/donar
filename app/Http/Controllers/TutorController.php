<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\DonationResponse;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'tutor']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        $pets = $user->pets()->with('healthConditions')->get();
        
        $stats = [
            'my_pets' => $pets->count(),
            'approved_donors' => $pets->where('donor_status', 'approved')->count(),
            'total_donations' => DonationResponse::where('tutor_id', $user->id)
                                               ->where('response', 'completed')->count(),
            'pending_requests' => DonationResponse::where('tutor_id', $user->id)
                                                 ->where('response', 'interested')->count()
        ];

        $recentRequests = DonationResponse::where('tutor_id', $user->id)
                                        ->with('bloodRequest.veterinarian', 'pet')
                                        ->latest()
                                        ->take(5)
                                        ->get();

        return view('tutor.dashboard', compact('stats', 'pets', 'recentRequests'));
    }

    public function respondToDonationRequest(Request $request, $requestId)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'response' => 'required|in:interested,not_available',
            'notes' => 'nullable|string|max:500'
        ]);

        $bloodRequest = BloodRequest::findOrFail($requestId);
        $pet = Pet::where('id', $validated['pet_id'])
                  ->where('tutor_id', Auth::id())
                  ->firstOrFail();

        // Verificar si ya respondió
        $existingResponse = DonationResponse::where('blood_request_id', $requestId)
                                          ->where('pet_id', $pet->id)
                                          ->where('tutor_id', Auth::id())
                                          ->first();

        if ($existingResponse) {
            return back()->withErrors(['error' => 'Ya has respondido a esta solicitud']);
        }

        DonationResponse::create([
            'blood_request_id' => $requestId,
            'pet_id' => $pet->id,
            'tutor_id' => Auth::id(),
            'response' => $validated['response'],
            'notes' => $validated['notes'],
            'responded_at' => now()
        ]);

        $message = $validated['response'] === 'interested' 
            ? 'Gracias por tu interés en ayudar. El veterinario se pondrá en contacto contigo.'
            : 'Gracias por responder. Esperamos puedas ayudar en otra ocasión.';

        return back()->with('success', $message);
    }

    public function markDonationCompleted(Request $request, $responseId)
    {
        $donationResponse = DonationResponse::where('id', $responseId)
                                          ->where('tutor_id', Auth::id())
                                          ->where('response', 'interested')
                                          ->firstOrFail();

        $donationResponse->update([
            'response' => 'completed',
            'notes' => ($donationResponse->notes ?? '') . ' - Donación completada el ' . now()->format('d/m/Y H:i')
        ]);

        // Marcar la solicitud como cumplida si es la primera donación completada
        $bloodRequest = $donationResponse->bloodRequest;
        if ($bloodRequest->status === 'active') {
            $bloodRequest->markAsFulfilled();
        }

        return back()->with('success', '¡Gracias por completar la donación! Has salvado una vida.');
    }


}