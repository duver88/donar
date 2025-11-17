@extends('layouts.app')

@section('title', 'Detalles de Solicitud - ' . $request->patient_name)

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        <i class="fas fa-file-medical me-2"></i>
                        Solicitud #{{ $request->id }}
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Paciente: <strong>{{ $request->patient_name }}</strong> • Creada {{ $request->created_at->diffForHumans() }}
                        @switch($request->urgency_level)
                            @case('critica')
                                • <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A;">
                                    <i class="fas fa-exclamation-triangle me-1"></i> CRÍTICA
                                </span>
                                @break
                            @case('alta')
                                • <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B;">
                                    <i class="fas fa-exclamation me-1"></i> ALTA
                                </span>
                                @break
                            @case('media')
                                • <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F;">
                                    <i class="fas fa-info me-1"></i> MEDIA
                                </span>
                                @break
                            @case('baja')
                                • <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d;">
                                    <i class="fas fa-minus me-1"></i> BAJA
                                </span>
                                @break
                        @endswitch
                    </p>
                </div>
                <div>
                    <a href="{{ route('veterinarian.dashboard') }}"
                       class="btn"
                       style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">

        <div class="row g-4">
            <!-- Columna principal -->
            <div class="col-lg-8">
                <!-- Información del Paciente -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-paw me-2"></i> Información del Paciente
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Nombre del paciente</small>
                                    <strong style="color: #43883D; font-size: 1.1rem;">{{ $request->patient_name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Raza</small>
                                    <strong style="color: #43883D;">{{ $request->patient_breed }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Peso</small>
                                    <strong style="color: #43883D;">{{ $request->patient_weight }} kg</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Tipo de sangre necesaria</small>
                                    <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.9rem; font-weight: 500;">
                                        🩸 {{ $request->blood_type_needed ?? $request->blood_type }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Estado actual</small>
                                    @switch($request->status)
                                        @case('active')
                                            <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.9rem; font-weight: 500;">
                                                <i class="fas fa-heartbeat me-1"></i> Activa
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.9rem; font-weight: 500;">
                                                <i class="fas fa-check me-1"></i> Completada
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.9rem; font-weight: 500;">
                                                <i class="fas fa-times me-1"></i> Cancelada
                                            </span>
                                            @break
                                        @case('expired')
                                            <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.9rem; font-weight: 500;">
                                                <i class="fas fa-clock me-1"></i> Expirada
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                            @if($request->needed_by_date)
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Fecha límite</small>
                                    <strong style="color: {{ $request->needed_by_date < now() && $request->status === 'active' ? '#C20E1A' : '#43883D' }};">
                                        {{ $request->needed_by_date->format('d/m/Y H:i') }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">{{ $request->needed_by_date->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información Médica -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-stethoscope me-2"></i> Información Médica
                        </h5>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #43883D;">
                                    <small class="text-muted d-block">Razón médica</small>
                                    <strong style="color: #43883D;">{{ $request->medical_reason }}</strong>
                                </div>
                            </div>

                            @if($request->additional_notes)
                            <div class="col-12">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #93C01F;">
                                    <small class="text-muted d-block">Notas adicionales</small>
                                    <strong style="color: #43883D;">{{ $request->additional_notes }}</strong>
                                </div>
                            </div>
                            @endif

                            <div class="col-12">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #F8DC0B;">
                                    <small class="text-muted d-block">Contacto de la clínica</small>
                                    <strong style="color: #43883D;">
                                        <i class="fas fa-phone me-2"></i>
                                        {{ $request->clinic_contact }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Respuestas de Donantes -->
                @if($request->donationResponses && $request->donationResponses->count() > 0)
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-users me-2"></i> Respuestas de Donantes ({{ $request->donationResponses->count() }})
                        </h5>
                        <div class="row g-3">
                            @foreach($request->donationResponses as $response)
                                <div class="col-md-6">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid {{ $response->response === 'interested' ? '#43883D' : '#6c757d' }};">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 style="color: #43883D; margin-bottom: 4px;">
                                                    <i class="fas fa-paw me-1"></i>
                                                    {{ $response->pet->name ?? 'Mascota no disponible' }}
                                                </h6>
                                                <small class="text-muted d-block">
                                                    Tutor: {{ $response->pet->tutor->name ?? 'No disponible' }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    {{ $response->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <span class="badge" style="background: {{ $response->response === 'interested' ? 'rgba(67, 136, 61, 0.1)' : 'rgba(108, 117, 125, 0.1)' }}; color: {{ $response->response === 'interested' ? '#43883D' : '#6c757d' }}; font-size: 0.75rem;">
                                                {{ $response->response === 'interested' ? '✅ Interesado' : '❌ No disponible' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
        </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Acciones -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-cogs me-2"></i> Acciones
                        </h5>
                        <div class="d-grid gap-3">
                            @if($request->status === 'active')
                                <button class="btn"
                                        style="background: #C20E1A; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px 20px;"
                                        data-bs-toggle="modal" data-bs-target="#cancelModal">
                                    <i class="fas fa-times me-2"></i> Cancelar Solicitud
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información del Proceso -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-info-circle me-2"></i> Proceso de Donación
                        </h5>
                        <div class="p-3 rounded mb-3" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #43883D;">
                            <h6 style="color: #43883D; margin-bottom: 8px;">📧 Coordinación a través de Bienestar Animal</h6>
                            <p class="mb-2 text-muted">Los donantes interesados responderán a:</p>
                            <p class="mb-0" style="color: #43883D; font-weight: 500;">binestaranimal@bucaramanga.gov.co</p>
                        </div>

                        <h6 style="color: #43883D;">¿Qué sigue?</h6>
                        <ol class="small text-muted">
                            <li>Los donantes compatibles reciben notificación por email</li>
                            <li>Los interesados responden a Bienestar Animal</li>
                            <li>Bienestar Animal coordina el contacto contigo</li>
                            <li>Se programa la donación en tu clínica</li>
                            <li>Se realiza la donación bajo supervisión profesional</li>
                        </ol>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-chart-bar me-2"></i> Estadísticas
                        </h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <div class="h4 mb-1" style="color: #43883D;">{{ $request->donationResponses->where('response', 'interested')->count() }}</div>
                                    <small class="text-muted">Interesados</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <div class="h4 mb-1" style="color: #6c757d;">{{ $request->donationResponses->where('response', 'not_available')->count() }}</div>
                                    <small class="text-muted">No disponibles</small>
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

<!-- Modal para cancelar solicitud -->
@if($request->status === 'active')
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: #43883D; color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title">
                    <i class="fas fa-times me-2"></i> Cancelar Solicitud
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('veterinarian.blood_request.cancel', $request->id) }}">
                @csrf
                <div class="modal-body p-4">
                    <p style="color: #43883D;">¿Estás seguro de que deseas cancelar esta solicitud?</p>
                    <p class="text-muted">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn"
                            style="background: transparent; color: #6c757d; border: 1px solid #6c757d; border-radius: 8px; padding: 8px 16px;"
                            data-bs-dismiss="modal">
                        No, mantener
                    </button>
                    <button type="submit" class="btn"
                            style="background: #C20E1A; color: white; border: none; border-radius: 8px; padding: 8px 16px;">
                        Sí, cancelar solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

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