<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Pet;
use App\Models\DonationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicRequestsController extends Controller
{
    /**
     * Muestra todas las solicitudes activas públicamente
     */
    public function index()
    {
        $activeRequests = BloodRequest::where('status', 'active')
            ->with(['veterinarian'])
            ->orderBy('urgency_level', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(12);

        return view('public.active-requests', compact('activeRequests'));
    }

    /**
     * Muestra solicitudes activas filtradas para una mascota específica
     */
    public function forPet(Pet $pet)
    {
        $bloodType = $pet->blood_type;

        // Filtrar por tipo de sangre si está definido
        $query = BloodRequest::where('status', 'active');

        if ($bloodType && $bloodType !== 'No determinado') {
            $query->where('blood_type', $bloodType);
        }

        $activeRequests = $query->with(['veterinarian'])
            ->orderBy('urgency_level', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('public.pet-active-requests', compact('activeRequests', 'pet'));
    }

    /**
     * Acepta una donación (enviará email al veterinario)
     */
    public function acceptDonation(Request $request, BloodRequest $bloodRequest)
    {
        $validator = Validator::make($request->all(), [
            'pet_id' => 'required|exists:pets,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'donor_phone' => 'required|string|max:20',
            'message' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pet = Pet::findOrFail($request->pet_id);

        // Crear respuesta de donación
        $donationResponse = DonationResponse::create([
            'blood_request_id' => $bloodRequest->id,
            'pet_id' => $pet->id,
            'status' => 'accepted',
            'response_date' => now(),
            'donor_name' => $request->donor_name,
            'donor_email' => $request->donor_email,
            'donor_phone' => $request->donor_phone,
            'message' => $request->message
        ]);

        // TODO: Enviar email al veterinario con los datos del donante

        return redirect()->back()->with('success',
            '¡Gracias por tu generosidad! El veterinario ' .
            ($bloodRequest->veterinarian->name ?? 'responsable') .
            ' se pondrá en contacto contigo pronto.');
    }

    /**
     * Declina una donación
     */
    public function declineDonation(Request $request, BloodRequest $bloodRequest)
    {
        $validator = Validator::make($request->all(), [
            'pet_id' => 'required|exists:pets,id',
            'reason' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $pet = Pet::findOrFail($request->pet_id);

        // Crear respuesta de donación
        DonationResponse::create([
            'blood_request_id' => $bloodRequest->id,
            'pet_id' => $pet->id,
            'status' => 'declined',
            'response_date' => now(),
            'reason' => $request->reason
        ]);

        return redirect()->back()->with('info',
            'Entendemos que no puedas ayudar en este momento. Gracias por considerar la donación.');
    }
}