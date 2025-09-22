<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\BloodRequest;
use App\Models\DonationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ActiveRequestsController extends Controller
{
    /**
     * Muestra las solicitudes activas para una mascota específica del usuario autenticado
     */
    public function index(Pet $pet)
    {
        // Verificar que el usuario sea el dueño de la mascota
        if ($pet->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta información.');
        }
        
        // Obtener solicitudes activas compatibles con la mascota
        $activeRequests = BloodRequest::where('status', 'active')
            ->where('blood_type', $pet->blood_type)
            ->where('city', $pet->user->city ?? '')
            ->with([
                'veterinarian.user',
                'donationResponses' => function($query) use ($pet) {
                    $query->where('pet_id', $pet->id);
                }
            ])
            ->orderBy('urgency_level', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
            
        // Obtener estadísticas para mostrar en la vista
        $stats = [
            'total_compatible' => $activeRequests->total(),
            'by_urgency' => BloodRequest::where('status', 'active')
                ->where('blood_type', $pet->blood_type)
                ->where('city', $pet->user->city ?? '')
                ->selectRaw('urgency_level, count(*) as count')
                ->groupBy('urgency_level')
                ->pluck('count', 'urgency_level'),
            'my_responses_count' => DonationResponse::where('user_id', Auth::id())
                ->where('pet_id', $pet->id)
                ->count()
        ];
            
        return view('active-requests.index', compact('pet', 'activeRequests', 'stats'));
    }
    
    /**
     * Página pública de solicitudes activas (sin autenticación requerida)
     */
    public function publicIndex(Request $request)
    {
        // Validar parámetros de filtro
        $validated = $request->validate([
            'blood_type' => 'nullable|string|in:DEA 1.1+,DEA 1.1-,DEA 3+,DEA 3-,DEA 4+,DEA 4-,DEA 5+,DEA 5-',
            'city' => 'nullable|string|max:100',
            'urgency' => 'nullable|string|in:alta,media,baja',
            'sort_by' => 'nullable|string|in:urgency,date,city',
            'sort_order' => 'nullable|string|in:asc,desc'
        ]);
        
        // Construir query base
        $query = BloodRequest::where('status', 'active')
            ->with(['veterinarian.user']);
            
        // Aplicar filtros
        if ($validated['blood_type'] ?? false) {
            $query->where('blood_type', $validated['blood_type']);
        }
        
        if ($validated['city'] ?? false) {
            $query->where('city', 'like', '%' . $validated['city'] . '%');
        }
        
        if ($validated['urgency'] ?? false) {
            $query->where('urgency_level', $validated['urgency']);
        }
        
        // Aplicar ordenamiento
        $sortBy = $validated['sort_by'] ?? 'urgency';
        $sortOrder = $validated['sort_order'] ?? 'desc';
        
        switch ($sortBy) {
            case 'urgency':
                $query->orderByRaw("FIELD(urgency_level, 'alta', 'media', 'baja') " . ($sortOrder === 'desc' ? 'ASC' : 'DESC'));
                $query->orderBy('created_at', 'asc'); // Secundario: más antiguos primero
                break;
            case 'date':
                $query->orderBy('created_at', $sortOrder);
                break;
            case 'city':
                $query->orderBy('city', $sortOrder);
                $query->orderBy('urgency_level', 'desc'); // Secundario: más urgentes primero
                break;
            default:
                $query->orderBy('urgency_level', 'desc');
                $query->orderBy('created_at', 'asc');
        }
        
        // Obtener resultados paginados
        $activeRequests = $query->paginate(15)->appends(request()->query());
            
        // Obtener datos para filtros (con cache por 10 minutos)
        $filterData = Cache::remember('blood_requests_filters', 600, function () {
            return [
                'blood_types' => BloodRequest::where('status', 'active')
                    ->distinct()
                    ->orderBy('blood_type')
                    ->pluck('blood_type'),
                'cities' => BloodRequest::where('status', 'active')
                    ->whereNotNull('city')
                    ->distinct()
                    ->orderBy('city')
                    ->pluck('city'),
                'urgency_levels' => ['alta', 'media', 'baja']
            ];
        });
        
        // Estadísticas generales (con cache por 5 minutos)
        $generalStats = Cache::remember('blood_requests_stats', 300, function () {
            return [
                'total_active' => BloodRequest::where('status', 'active')->count(),
                'by_urgency' => BloodRequest::where('status', 'active')
                    ->selectRaw('urgency_level, count(*) as count')
                    ->groupBy('urgency_level')
                    ->pluck('count', 'urgency_level'),
                'by_blood_type' => BloodRequest::where('status', 'active')
                    ->selectRaw('blood_type, count(*) as count')
                    ->groupBy('blood_type')
                    ->orderByDesc('count')
                    ->pluck('count', 'blood_type'),
                'cities_with_requests' => BloodRequest::where('status', 'active')
                    ->whereNotNull('city')
                    ->distinct('city')
                    ->count()
            ];
        });
            
        return view('active-requests.public', compact(
            'activeRequests', 
            'filterData',
            'generalStats',
            'validated'
        ));
    }
    
    /**
     * API endpoint para obtener estadísticas de solicitudes activas
     */
    public function stats(Request $request)
    {
        $type = $request->get('type', 'general');
        
        try {
            switch ($type) {
                case 'general':
                    $stats = Cache::remember('api_blood_requests_general_stats', 300, function () {
                        return [
                            'total_active' => BloodRequest::where('status', 'active')->count(),
                            'total_completed' => BloodRequest::where('status', 'completed')->count(),
                            'total_pending' => BloodRequest::where('status', 'pending')->count(),
                            'response_rate' => $this->calculateResponseRate()
                        ];
                    });
                    break;
                    
                case 'urgency':
                    $stats = Cache::remember('api_blood_requests_urgency_stats', 300, function () {
                        return BloodRequest::where('status', 'active')
                            ->selectRaw('urgency_level, count(*) as count')
                            ->groupBy('urgency_level')
                            ->pluck('count', 'urgency_level');
                    });
                    break;
                    
                case 'blood_type':
                    $stats = Cache::remember('api_blood_requests_blood_type_stats', 300, function () {
                        return BloodRequest::where('status', 'active')
                            ->selectRaw('blood_type, count(*) as count')
                            ->groupBy('blood_type')
                            ->orderByDesc('count')
                            ->pluck('count', 'blood_type');
                    });
                    break;
                    
                case 'location':
                    $stats = Cache::remember('api_blood_requests_location_stats', 300, function () {
                        return BloodRequest::where('status', 'active')
                            ->whereNotNull('city')
                            ->selectRaw('city, count(*) as count')
                            ->groupBy('city')
                            ->orderByDesc('count')
                            ->limit(10)
                            ->pluck('count', 'city');
                    });
                    break;
                    
                case 'timeline':
                    $stats = Cache::remember('api_blood_requests_timeline_stats', 300, function () {
                        return BloodRequest::where('status', 'active')
                            ->where('created_at', '>=', now()->subDays(30))
                            ->selectRaw('DATE(created_at) as date, count(*) as count')
                            ->groupBy('date')
                            ->orderBy('date')
                            ->pluck('count', 'date');
                    });
                    break;
                    
                default:
                    return response()->json(['error' => 'Tipo de estadística no válido'], 400);
            }
            
            return response()->json([
                'success' => true,
                'type' => $type,
                'data' => $stats,
                'generated_at' => now()->toISOString()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error obteniendo estadísticas de solicitudes activas', [
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }
    
    /**
     * Busca solicitudes activas para una mascota específica (usado en AJAX)
     */
    public function searchForPet(Request $request, Pet $pet)
    {
        // Verificar que el usuario sea el dueño de la mascota
        if ($pet->user_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        $validated = $request->validate([
            'urgency' => 'nullable|string|in:alta,media,baja',
            'limit' => 'nullable|integer|min:1|max:50'
        ]);
        
        try {
            $query = BloodRequest::where('status', 'active')
                ->where('blood_type', $pet->blood_type)
                ->where('city', $pet->user->city ?? '')
                ->with(['veterinarian.user']);
                
            if ($validated['urgency'] ?? false) {
                $query->where('urgency_level', $validated['urgency']);
            }
            
            $limit = $validated['limit'] ?? 10;
            
            $requests = $query->orderBy('urgency_level', 'desc')
                ->orderBy('created_at', 'asc')
                ->limit($limit)
                ->get()
                ->map(function ($request) use ($pet) {
                    return [
                        'id' => $request->id,
                        'patient_name' => $request->patient_name,
                        'urgency_level' => $request->urgency_level,
                        'description' => $request->description,
                        'veterinarian' => [
                            'name' => $request->veterinarian->user->name,
                            'clinic' => $request->veterinarian->clinic_name
                        ],
                        'created_at' => $request->created_at->diffForHumans(),
                        'has_responded' => DonationResponse::where('blood_request_id', $request->id)
                            ->where('pet_id', $pet->id)
                            ->exists()
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $requests,
                'pet' => [
                    'id' => $pet->id,
                    'name' => $pet->name,
                    'blood_type' => $pet->blood_type
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error buscando solicitudes para mascota', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }
    
    /**
     * Endpoint para marcar solicitudes como vistas (tracking de usuario)
     */
    public function markAsViewed(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }
        
        $validated = $request->validate([
            'request_ids' => 'required|array',
            'request_ids.*' => 'integer|exists:blood_requests,id'
        ]);
        
        try {
            // Aquí podrías implementar un tracking de qué solicitudes ha visto cada usuario
            // Por ejemplo, creando una tabla 'blood_request_views'
            
            foreach ($validated['request_ids'] as $requestId) {
                // Lógica para marcar como vista
                Log::info('Solicitud vista por usuario', [
                    'user_id' => Auth::id(),
                    'blood_request_id' => $requestId
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Solicitudes marcadas como vistas'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error marcando solicitudes como vistas', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error interno del servidor'
            ], 500);
        }
    }
    
    /**
     * Calcula la tasa de respuesta general del sistema
     */
    private function calculateResponseRate()
    {
        $totalRequests = BloodRequest::where('created_at', '>=', now()->subDays(30))->count();
        
        if ($totalRequests === 0) {
            return 0;
        }
        
        $requestsWithResponses = BloodRequest::where('created_at', '>=', now()->subDays(30))
            ->whereHas('donationResponses')
            ->count();
            
        return round(($requestsWithResponses / $totalRequests) * 100, 2);
    }
    
    /**
     * Página de ayuda sobre cómo funciona el sistema de solicitudes
     */
    public function help()
    {
        $faqData = [
            [
                'question' => '¿Cómo funciona el sistema de donación?',
                'answer' => 'Cuando un veterinario necesita sangre para un paciente, envía una solicitud al sistema. Automáticamente se notifica a todos los tutores de mascotas compatibles por email.'
            ],
            [
                'question' => '¿Qué tipos de sangre canina existen?',
                'answer' => 'Los principales tipos son DEA 1.1+, DEA 1.1-, DEA 3+, DEA 3-, DEA 4+, DEA 4-, DEA 5+, DEA 5-. El veterinario determinará el tipo de sangre de tu mascota.'
            ],
            [
                'question' => '¿Mi mascota puede donar sangre?',
                'answer' => 'Las mascotas donantes deben estar sanas, pesar más de 25kg, tener entre 1-8 años, estar al día con vacunas y no haber donado en los últimos 3 meses.'
            ],
            [
                'question' => '¿Cómo respondo a una solicitud?',
                'answer' => 'Puedes responder directamente desde el email que recibes, o desde esta página web. Solo haz clic en "Quiero ayudar" o "No puedo ahora".'
            ],
            [
                'question' => '¿Qué pasa después de aceptar una donación?',
                'answer' => 'El veterinario se pondrá en contacto contigo directamente para coordinar fecha, hora y lugar de la donación.'
            ]
        ];
        
        return view('active-requests.help', compact('faqData'));
    }
}