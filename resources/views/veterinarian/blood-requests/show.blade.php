@extends('layouts.app')

@section('title', 'Detalles de Solicitud - ' . $request->patient_name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header con información básica -->
            <div class="card shadow mb-4">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border-radius: 0.5rem 0.5rem 0 0;">
                    <div>
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-file-medical me-2" style="color: #fbbf24;"></i>
                            Solicitud #{{ $request->id }} - {{ $request->patient_name }}
                        </h4>
                        <small class="d-block mt-1" style="opacity: 0.9;">
                            Creada {{ $request->created_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="text-end">
                        @switch($request->urgency_level)
                            @case('critica')
                                <span class="badge" style="background: #dc2626; font-size: 1rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-exclamation-triangle"></i> CRÍTICA
                                </span>
                                @break
                            @case('alta')
                                <span class="badge" style="background: #f59e0b; font-size: 1rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-exclamation"></i> ALTA
                                </span>
                                @break
                            @case('media')
                                <span class="badge" style="background: #0891b2; font-size: 1rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-info"></i> MEDIA
                                </span>
                                @break
                            @case('baja')
                                <span class="badge" style="background: #6b7280; font-size: 1rem; padding: 0.5rem 1rem;">
                                    <i class="fas fa-minus"></i> BAJA
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Columna principal -->
        <div class="col-lg-8">
            <!-- Información del Paciente -->
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-dog me-2" style="color: #fbbf24;"></i> Información del Paciente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Nombre del Paciente:</label>
                                <p class="mb-0 fs-5">{{ $request->patient_name }}</p>
                            </div>
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Raza:</label>
                                <p class="mb-0">{{ $request->patient_breed }}</p>
                            </div>
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Peso:</label>
                                <p class="mb-0">
                                    <i class="fas fa-weight me-1 text-primary"></i>
                                    {{ $request->patient_weight }} kg
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Tipo de Sangre Necesaria:</label>
                                <p class="mb-0">
                                    <span class="badge" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); font-size: 1rem; padding: 0.5rem 1rem;">
                                        🩸 {{ $request->blood_type_needed ?? $request->blood_type }}
                                    </span>
                                </p>
                            </div>
                            <div class="info-item mb-3">
                                <label class="fw-bold text-muted">Estado:</label>
                                <p class="mb-0">
                                    @switch($request->status)
                                        @case('active')
                                            <span class="badge bg-success">
                                                <i class="fas fa-heartbeat"></i> Activa
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-check"></i> Completada
                                            </span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times"></i> Cancelada
                                            </span>
                                            @break
                                        @case('expired')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-clock"></i> Expirada
                                            </span>
                                            @break
                                    @endswitch
                                </p>
                            </div>
                            @if($request->needed_by_date)
                                <div class="info-item mb-3">
                                    <label class="fw-bold text-muted">Fecha Límite:</label>
                                    <p class="mb-0 {{ $request->needed_by_date < now() && $request->status === 'active' ? 'text-danger fw-bold' : '' }}">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $request->needed_by_date->format('d/m/Y H:i') }}
                                        <br>
                                        <small class="text-muted">{{ $request->needed_by_date->diffForHumans() }}</small>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Médica -->
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-stethoscope me-2" style="color: #fbbf24;"></i> Información Médica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item mb-3">
                        <label class="fw-bold text-muted">Razón Médica:</label>
                        <div class="mt-2 p-3 rounded" style="background-color: #f8f9fa; border-left: 4px solid #059669;">
                            {{ $request->medical_reason }}
                        </div>
                    </div>

                    @if($request->additional_notes)
                        <div class="info-item mb-3">
                            <label class="fw-bold text-muted">Notas Adicionales:</label>
                            <div class="mt-2 p-3 rounded" style="background-color: #eff6ff; border-left: 4px solid #1e3a8a;">
                                {{ $request->additional_notes }}
                            </div>
                        </div>
                    @endif

                    <div class="info-item mb-3">
                        <label class="fw-bold text-muted">Información de Contacto de la Clínica:</label>
                        <div class="mt-2 p-3 rounded" style="background-color: #fef3cd; border-left: 4px solid #f59e0b;">
                            <i class="fas fa-phone me-2 text-warning"></i>
                            {{ $request->clinic_contact }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Respuestas de Donantes -->
            @if($request->donationResponses && $request->donationResponses->count() > 0)
                <div class="card shadow mb-4">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-users me-2" style="color: #1e3a8a;"></i>
                            Respuestas de Donantes ({{ $request->donationResponses->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($request->donationResponses as $response)
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 {{ $response->response === 'interested' ? 'border-success bg-light' : 'border-secondary' }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="fas fa-dog me-1"></i>
                                                    {{ $response->pet->name ?? 'Mascota no disponible' }}
                                                </h6>
                                                <small class="text-muted">
                                                    Tutor: {{ $response->pet->tutor->name ?? 'No disponible' }}
                                                </small>
                                            </div>
                                            <span class="badge {{ $response->response === 'interested' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $response->response === 'interested' ? '✅ Interesado' : '❌ No disponible' }}
                                            </span>
                                        </div>
                                        <small class="text-muted d-block mt-2">
                                            {{ $response->created_at->diffForHumans() }}
                                        </small>
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
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-cogs me-2" style="color: #fbbf24;"></i> Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('veterinarian.dashboard') }}" class="btn fw-semibold" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; border: none; border-radius: 0.5rem;">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                        </a>

                        @if($request->status === 'active')
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                <i class="fas fa-times me-2"></i> Cancelar Solicitud
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información del Proceso -->
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2" style="color: #fbbf24;"></i> Proceso de Donación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert" style="background: #eff6ff; border-left: 4px solid #1e3a8a; border-color: #bfdbfe;">
                        <h6 style="color: #1e3a8a;">📧 Coordinación a través de Bienestar Animal</h6>
                        <p class="mb-2" style="color: #1e3a8a;">Los donantes interesados responderán a:</p>
                        <p class="mb-0 fw-bold" style="color: #1e3a8a;">binestaranimal@bucaramanga.gov.co</p>
                    </div>

                    <h6 class="text-primary">¿Qué sigue?</h6>
                    <ol class="small">
                        <li>Los donantes compatibles reciben notificación por email</li>
                        <li>Los interesados responden a Bienestar Animal</li>
                        <li>Bienestar Animal coordina el contacto contigo</li>
                        <li>Se programa la donación en tu clínica</li>
                        <li>Se realiza la donación bajo supervisión profesional</li>
                    </ol>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2" style="color: #fbbf24;"></i> Estadísticas
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-6">
                            <div class="p-2">
                                <div class="h4 mb-0 text-success">{{ $request->donationResponses->where('response', 'interested')->count() }}</div>
                                <small class="text-muted">Interesados</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2">
                                <div class="h4 mb-0 text-secondary">{{ $request->donationResponses->where('response', 'not_available')->count() }}</div>
                                <small class="text-muted">No disponibles</small>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('veterinarian.blood_request.cancel', $request->id) }}">
                @csrf
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas cancelar esta solicitud?</p>
                    <p class="text-muted">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, mantener</button>
                    <button type="submit" class="btn btn-danger">Sí, cancelar solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection