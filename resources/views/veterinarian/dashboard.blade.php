{{-- resources/views/veterinarian/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Veterinario')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header Veterinario --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        <i class="fas fa-user-md me-2"></i>
                        Panel Veterinario
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Bienvenido, <strong>Dr. {{ Auth::user()->name }}</strong> • {{ Auth::user()->veterinarian->clinic_name ?? 'Clínica Veterinaria' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('veterinarian.blood_request.create') }}"
                       class="btn"
                       style="background: #43883D; color: white; border: none; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-plus me-2"></i>Nueva Solicitud de Donación
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    <div class="container-fluid px-4">
        <div class="row g-3 mb-4">
            {{-- Mis Solicitudes --}}
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #43883D;">
                            {{ $stats['my_requests'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Mis Solicitudes</p>
                        <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem;">
                            Total histórico
                        </span>
                    </div>
                </div>
            </div>

            {{-- Solicitudes Activas --}}
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #F8DC0B;">
                            {{ $stats['active_requests'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Solicitudes Activas</p>
                        @if($stats['active_requests'] > 0)
                            <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem;">
                                En proceso urgente
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Donantes Disponibles --}}
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #93C01F;">
                            {{ $stats['available_donors'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Donantes Disponibles</p>
                        <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem;">
                            Red completa
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel de Mis Solicitudes --}}
        <div class="row g-4">
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-medium mb-0" style="color: #43883D; font-family: 'Ubuntu', sans-serif;">
                                <i class="fas fa-file-medical me-2"></i>
                                Mis Solicitudes de Donación
                            </h5>
                            <a href="{{ route('veterinarian.blood_request.create') }}"
                               class="btn btn-sm"
                               style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 8px 16px;">
                                <i class="fas fa-plus me-2"></i>Nueva Solicitud
                            </a>
                        </div>

                        @if($myRequests->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead style="background: #43883D;">
                                        <tr>
                                            <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Paciente</th>
                                            <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Urgencia</th>
                                            <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Fecha Límite</th>
                                            <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Estado</th>
                                            <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Respuestas</th>
                                            <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($myRequests as $request)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $request->patient_name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $request->patient_breed ?? 'Raza no especificada' }} • {{ $request->patient_weight ?? 'N/A' }}kg</small>
                                                </div>
                                            </td>
                                            <td style="padding: 1rem;">
                                                @switch($request->urgency_level)
                                                    @case('critica')
                                                        <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-exclamation-triangle me-1"></i> Crítica
                                                        </span>
                                                        @break
                                                    @case('alta')
                                                        <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-exclamation me-1"></i> Alta
                                                        </span>
                                                        @break
                                                    @case('media')
                                                        <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-info me-1"></i> Media
                                                        </span>
                                                        @break
                                                    @case('baja')
                                                        <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-minus me-1"></i> Baja
                                                        </span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($request->needed_by_date)
                                                    <div>
                                                        <strong style="color: #43883D;">{{ $request->needed_by_date->format('d/m/Y H:i') }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $request->needed_by_date->diffForHumans() }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td style="padding: 1rem;">
                                                @switch($request->status)
                                                    @case('active')
                                                        <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-heartbeat me-1"></i> Activa
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-check me-1"></i> Completada
                                                        </span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-times me-1"></i> Cancelada
                                                        </span>
                                                        @break
                                                    @case('expired')
                                                        <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem; font-weight: 500;">
                                                            <i class="fas fa-clock me-1"></i> Expirada
                                                        </span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td style="padding: 1rem;">
                                                <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem; font-weight: 500;">
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $request->donationResponses ? $request->donationResponses->count() : 0 }} interesados
                                                </span>
                                            </td>
                                            <td style="padding: 1rem;">
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('veterinarian.blood_request.show', $request->id) }}"
                                                       class="btn btn-sm"
                                                       style="background: #43883D; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
                                                       title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($request->status === 'active')
                                                        <button class="btn btn-sm"
                                                                style="background: #C20E1A; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
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
                                <i class="fas fa-file-medical fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">¡Comienza tu primera solicitud!</h6>
                                <p class="text-muted mb-4">Aún no has creado ninguna solicitud de donación de sangre</p>
                                <a href="{{ route('veterinarian.blood_request.create') }}"
                                   class="btn"
                                   style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px 24px;">
                                    <i class="fas fa-plus me-2"></i>Crear Primera Solicitud
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Panel Lateral con Información --}}
            <div class="col-xl-4 col-lg-5">
                <div class="row g-4">
                    {{-- Mi Información Profesional --}}
                    <div class="col-12">
                        <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4">
                                <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                                    <i class="fas fa-user-md me-2"></i> Mi Información Profesional
                                </h5>

                                {{-- Información de contacto y profesional --}}
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Nombre completo</small>
                                            <strong style="color: #43883D;">Dr. {{ Auth::user()->name }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Clínica</small>
                                            <strong style="color: #43883D;">{{ Auth::user()->veterinarian->clinic_name ?? 'No especificada' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Dirección</small>
                                            <strong style="color: #43883D;">{{ Auth::user()->veterinarian->clinic_address ?? 'No especificada' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Ciudad</small>
                                            <strong style="color: #43883D;">{{ Auth::user()->veterinarian->city ?? 'No especificada' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Tarjeta Profesional</small>
                                            <strong style="color: #43883D;">{{ Auth::user()->veterinarian->professional_card ?? 'No especificada' }}</strong>
                                        </div>
                                    </div>
                                    @if(Auth::user()->veterinarian->specialty)
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Especialidad</small>
                                            <strong style="color: #43883D;">{{ Auth::user()->veterinarian->specialty }}</strong>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Consejos y Mejores Prácticas --}}
                    <div class="col-12">
                        <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4">
                                <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                                    <i class="fas fa-lightbulb me-2"></i> Consejos Profesionales
                                </h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #C20E1A;">
                                            <h6 style="color: #43883D; margin-bottom: 8px;">Solicitudes Críticas</h6>
                                            <p class="text-muted small mb-0">Tienen máxima prioridad y notificación inmediata a donantes</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #F8DC0B;">
                                            <h6 style="color: #43883D; margin-bottom: 8px;">Información Completa</h6>
                                            <p class="text-muted small mb-0">Incluye todos los detalles médicos para mejores respuestas</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #93C01F;">
                                            <h6 style="color: #43883D; margin-bottom: 8px;">Contacto Directo</h6>
                                            <p class="text-muted small mb-0">Comunícate directamente con tutores interesados</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #43883D;">
                                            <h6 style="color: #43883D; margin-bottom: 8px;">Tiempo de Respuesta</h6>
                                            <p class="text-muted small mb-0">Típicamente 1-2 horas para emergencias</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilos consistentes --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');

* {
    font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border-radius: 12px !important;
    border: none;
}

.btn {
    font-weight: 500;
    transition: all 0.2s ease;
}

.badge {
    border-radius: 6px;
    font-size: 0.8rem;
    padding: 6px 12px;
}
</style>

@endsection

@section('scripts')
<script>
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