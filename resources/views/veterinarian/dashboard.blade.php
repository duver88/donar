{{-- resources/views/veterinarian/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Veterinario')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-user-md text-success"></i> Dashboard Veterinario</h2>
                    <p class="text-muted mb-0">Bienvenido, Dr. {{ Auth::user()->name }}</p>
                </div>
                <div>
                    <a href="{{ route('veterinarian.blood_request.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nueva Solicitud de Donación
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['my_requests'] }}</h4>
                            <p class="mb-0">Mis Solicitudes</p>
                        </div>
                        <div>
                            <i class="fas fa-file-medical fa-3x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-chart-line"></i> Total histórico
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['active_requests'] }}</h4>
                            <p class="mb-0">Solicitudes Activas</p>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-3x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-hourglass-half"></i> En proceso
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['available_donors'] }}</h4>
                            <p class="mb-0">Donantes Disponibles</p>
                        </div>
                        <div>
                            <i class="fas fa-dog fa-3x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-heart"></i> En toda la red
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Mis Solicitudes --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list text-primary"></i> Mis Solicitudes de Donación</h5>
                    <a href="{{ route('veterinarian.blood_request.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Nueva Solicitud
                    </a>
                </div>
                <div class="card-body">
                    @if($myRequests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Paciente</th>
                                        <th>Urgencia</th>
                                        <th>Fecha Límite</th>
                                        <th>Estado</th>
                                        <th>Respuestas</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myRequests as $request)
                                    <tr class="{{ $request->is_urgent ? 'table-warning' : '' }}">
                                        <td>
                                            <div>
                                                <strong>{{ $request->patient_name }}</strong><br>
                                                <small class="text-muted">{{ $request->patient_breed }}</small><br>
                                                <small class="text-muted">{{ $request->patient_weight }}kg</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $request->urgency_color }}">
                                                {{ ucfirst($request->urgency_level) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                {{ $request->needed_by_date->format('d/m/Y H:i') }}<br>
                                                <small class="text-muted">{{ $request->time_remaining }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $request->status === 'active' ? 'success' : 'secondary' }}">
                                                {{ $request->status_display }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $request->interested_donors_count }} interesados
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" 
                                                        onclick="viewRequest({{ $request->id }})"
                                                        title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($request->status === 'active')
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="cancelRequest({{ $request->id }})"
                                                            title="Cancelar solicitud">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-medical fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No has realizado ninguna solicitud aún</h5>
                            <p class="text-muted mb-3">Crea tu primera solicitud de donación de sangre</p>
                            <a href="{{ route('veterinarian.blood_request.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Crear Primera Solicitud
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Información de Contacto --}}
            <div class="card shadow mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-info"></i> Mi Información</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-hospital fa-3x text-primary mb-2"></i>
                        <h6 class="mb-0">{{ Auth::user()->veterinarian->clinic_name }}</h6>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        <strong>Dirección:</strong><br>
                        <small class="text-muted">{{ Auth::user()->veterinarian->clinic_address }}</small>
                    </div>
                    
                    <div class="mb-2">
                        <i class="fas fa-city text-primary"></i>
                        <strong>Ciudad:</strong> {{ Auth::user()->veterinarian->city }}
                    </div>
                    
                    <hr>
                    
                    <div class="mb-2">
                        <i class="fas fa-id-card text-success"></i>
                        <strong>Tarjeta Profesional:</strong><br>
                        <small class="text-muted">{{ Auth::user()->veterinarian->professional_card }}</small>
                    </div>
                    
                    @if(Auth::user()->veterinarian->specialty)
                        <div class="mb-2">
                            <i class="fas fa-stethoscope text-warning"></i>
                            <strong>Especialidad:</strong><br>
                            <small class="text-muted">{{ Auth::user()->veterinarian->specialty }}</small>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Consejos --}}
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-lightbulb text-warning"></i> Consejos y Buenas Prácticas</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-check text-success"></i>
                            <strong>Solicitudes críticas</strong><br>
                            <small class="text-muted">Tienen prioridad y llegan inmediatamente a los donantes</small>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-success"></i>
                            <strong>Detalles médicos</strong><br>
                            <small class="text-muted">Proporciona información completa para mejores respuestas</small>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check text-success"></i>
                            <strong>Contacto directo</strong><br>
                            <small class="text-muted">Llama directamente a los tutores interesados</small>
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success"></i>
                            <strong>Tiempo de respuesta</strong><br>
                            <small class="text-muted">Los donantes suelen responder en 1-2 horas</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para ver detalles de solicitud --}}
<div class="modal fade" id="requestModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-medical text-primary"></i> Detalles de la Solicitud
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="requestDetails">
                    <!-- Los detalles se cargarán aquí via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewRequest(id) {
    // Por ahora mostramos un alert, pero podrías implementar un modal con detalles completos
    alert('Ver detalles de solicitud #' + id + '\n\nEsta funcionalidad se puede expandir para mostrar:\n- Detalles completos del paciente\n- Lista de donantes que respondieron\n- Historial de la solicitud');
}

function cancelRequest(id) {
    if (confirm('¿Estás seguro de que deseas cancelar esta solicitud?\n\nEsta acción no se puede deshacer.')) {
        fetch(`/veterinario/solicitud/${id}/cancelar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al cancelar la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}
</script>
@endsection