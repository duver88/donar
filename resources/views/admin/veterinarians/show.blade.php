@extends('layouts.app')

@section('title', 'Detalles de ' . $veterinarian->name)

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        <i class="fas fa-user-md me-2"></i>
                        Detalles del Veterinario
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        <strong>{{ $veterinarian->name }}</strong> • {{ $veterinarian->veterinarian?->clinic_name ?? 'Sin clínica' }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.veterinarians') }}"
                       class="btn"
                       style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Información Principal -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-user-md me-2"></i> Información Personal
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Nombre completo</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->name }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Estado</small>
                                    @switch($veterinarian->status)
                                        @case('pending')
                                            <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.9rem;">
                                                <i class="fas fa-clock me-1"></i> Pendiente
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.9rem;">
                                                <i class="fas fa-check me-1"></i> Aprobado
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.9rem;">
                                                <i class="fas fa-times me-1"></i> Rechazado
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Email</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->email }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Teléfono</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->phone }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Documento</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->document_id ?? 'No registrado' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Fecha de registro</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->created_at->format('d/m/Y H:i') }}</strong>
                                </div>
                            </div>
                            @if($veterinarian->approved_at)
                            <div class="col-12">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #43883D;">
                                    <small class="text-muted d-block">Fecha de aprobación</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->approved_at->format('d/m/Y H:i') }}</strong>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

                <!-- Información Profesional -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-id-card me-2"></i> Información Profesional
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Tarjeta Profesional</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->veterinarian?->professional_card ?? 'No registrada' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Especialidad</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->veterinarian?->specialty ?? 'No especificada' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Años de experiencia</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->veterinarian?->years_experience ?? 'No especificados' }} años</strong>
                                </div>
                            </div>
                            @if($veterinarian->veterinarian?->professional_card_photo)
                            <div class="col-md-6">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Documento profesional</small>
                                    <button type="button" class="btn btn-sm"
                                            style="background: rgba(67, 136, 61, 0.1); color: #43883D; border: none; border-radius: 6px;"
                                            data-bs-toggle="modal" data-bs-target="#cardPhotoModal">
                                        <i class="fas fa-eye me-1"></i> Ver tarjeta profesional
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información de la Clínica -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-hospital me-2"></i> Información de la Clínica
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Nombre de la clínica</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->veterinarian?->clinic_name ?? 'No registrada' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Ciudad</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->veterinarian?->city ?? 'No especificada' }}</strong>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <small class="text-muted d-block">Dirección completa</small>
                                    <strong style="color: #43883D;">{{ $veterinarian->veterinarian?->clinic_address ?? 'No registrada' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-lg-4">
                <!-- Solicitudes de Sangre (si las tiene) -->
                @if($veterinarian->veterinarian && $veterinarian->veterinarian->bloodRequests && $veterinarian->veterinarian->bloodRequests->count() > 0)
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-heartbeat me-2"></i> Solicitudes de Sangre
                            <span class="badge ms-2" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.8rem;">{{ $veterinarian->veterinarian->bloodRequests->count() }}</span>
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead style="background: #43883D;">
                                    <tr>
                                        <th style="color: white; font-size: 0.8rem; border: none;">Paciente</th>
                                        <th style="color: white; font-size: 0.8rem; border: none;">Estado</th>
                                        <th style="color: white; font-size: 0.8rem; border: none;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($veterinarian->veterinarian->bloodRequests->take(5) as $request)
                                    <tr style="border-bottom: 1px solid #f8f9fa;">
                                        <td style="border: none; padding: 8px 12px;">
                                            <strong style="color: #43883D; font-size: 0.9rem;">{{ $request->patient_name }}</strong><br>
                                            <small class="text-muted">{{ $request->patient_breed }}</small>
                                        </td>
                                        <td style="border: none; padding: 8px 12px;">
                                            @if($request->status === 'active')
                                                <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.7rem;">Activa</span>
                                            @elseif($request->status === 'completed')
                                                <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.7rem;">Completada</span>
                                            @else
                                                <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.7rem;">{{ ucfirst($request->status) }}</span>
                                            @endif
                                        </td>
                                        <td style="border: none; padding: 8px 12px;">
                                            <a href="{{ route('admin.blood_requests.show', $request->id) }}"
                                               class="btn btn-sm"
                                               style="background: rgba(67, 136, 61, 0.1); color: #43883D; border: none; border-radius: 6px; font-size: 0.8rem;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($veterinarian->veterinarian->bloodRequests->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.blood_requests') }}?veterinarian={{ $veterinarian->id }}"
                               class="btn btn-sm"
                               style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 6px; font-size: 0.9rem;">
                                <i class="fas fa-list me-1"></i> Ver todas ({{ $veterinarian->veterinarian->bloodRequests->count() }})
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @else
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-heartbeat me-2"></i> Solicitudes de Sangre
                        </h5>
                        <div style="color: #43883D; opacity: 0.6;">
                            <i class="fas fa-heartbeat" style="font-size: 2rem;"></i>
                        </div>
                        <h6 class="text-muted mt-3 mb-2">Sin solicitudes registradas</h6>
                        <p class="text-muted small mb-0">Este veterinario aún no ha realizado solicitudes de sangre.</p>
                    </div>
                </div>
                @endif

                <!-- Acciones -->
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                            <i class="fas fa-cogs me-2"></i> Acciones
                        </h5>
                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.veterinarians.edit', $veterinarian->id) }}"
                               class="btn"
                               style="background: #F8DC0B; color: #333; border: none; border-radius: 8px; font-weight: 500; padding: 12px 16px;">
                                <i class="fas fa-edit me-2"></i> Editar Información
                            </a>

                            @if($veterinarian->status === 'pending')
                            <div class="row g-2">
                                <div class="col-6">
                                    <form action="{{ route('admin.approve_veterinarian', $veterinarian->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn w-100"
                                                style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px 16px;">
                                            <i class="fas fa-check me-1"></i> Aprobar
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn w-100" data-bs-toggle="modal" data-bs-target="#rejectModal"
                                            style="background: #C20E1A; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px 16px;">
                                        <i class="fas fa-times me-1"></i> Rechazar
                                    </button>
                                </div>
                            </div>
                            @endif

                            <form action="{{ route('admin.veterinarians.destroy', $veterinarian->id) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este veterinario? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn w-100"
                                        style="background: transparent; color: #C20E1A; border: 1px solid #C20E1A; border-radius: 8px; font-weight: 500; padding: 12px 16px;">
                                    <i class="fas fa-trash me-2"></i> Eliminar Veterinario
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($veterinarian->veterinarian?->professional_card_photo)
<!-- Modal para mostrar la foto de la tarjeta profesional en grande -->
<div class="modal fade" id="cardPhotoModal" tabindex="-1" aria-labelledby="cardPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #43883D; color: white; border-radius: 12px 12px 0 0; border: none;">
                <h5 class="modal-title" id="cardPhotoModalLabel">
                    <i class="fas fa-id-card me-2"></i> Tarjeta Profesional de {{ $veterinarian->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $veterinarian->veterinarian->professional_card_photo) }}"
                         alt="Tarjeta profesional de {{ $veterinarian->name }}"
                         class="img-fluid w-100"
                         style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer" style="border: none; background: #fafafa;">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Tarjeta Profesional: {{ $veterinarian->veterinarian->professional_card }}
                        </small>
                    </div>
                    <div>
                        <a href="{{ asset('storage/' . $veterinarian->veterinarian->professional_card_photo) }}" target="_blank"
                           class="btn btn-sm me-2"
                           style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 6px;">
                            <i class="fas fa-external-link-alt me-1"></i> Abrir en nueva pestaña
                        </a>
                        <button type="button" class="btn btn-sm" data-bs-dismiss="modal"
                                style="background: #6c757d; color: white; border: none; border-radius: 6px;">
                            <i class="fas fa-times me-1"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($veterinarian->status === 'pending')
<!-- Modal para rechazar veterinario -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #C20E1A; color: white; border-radius: 12px 12px 0 0; border: none;">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-times me-2"></i> Rechazar Veterinario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('admin.reject_veterinarian', $veterinarian->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert" style="border-radius: 8px; border: none; background: rgba(248, 220, 11, 0.1);">
                        <i class="fas fa-exclamation-triangle" style="color: #F8DC0B;"></i>
                        <strong style="color: #43883D;">Atención:</strong> <span style="color: #43883D;">Vas a rechazar la solicitud de {{ $veterinarian->name }}.</span>
                    </div>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label" style="color: #43883D; font-weight: 500;">Motivo del rechazo *</label>
                        <textarea class="form-control" name="rejection_reason" rows="4" required
                                  style="border: 1px solid #e3e6f0; border-radius: 8px; padding: 12px;"
                                  placeholder="Explica el motivo por el cual se rechaza la solicitud del veterinario..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; background: #fafafa; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background: transparent; color: #6c757d; border: 1px solid #6c757d; border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn"
                            style="background: #C20E1A; color: white; border: none; border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-times me-1"></i> Rechazar Veterinario
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

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e3e6f0;
    padding: 12px 16px;
    font-size: 0.9rem;
}

.form-control:focus, .form-select:focus {
    border-color: #43883D;
    box-shadow: 0 0 0 0.2rem rgba(67, 136, 61, 0.25);
}

.form-label {
    font-weight: 500;
    color: #43883D;
    margin-bottom: 8px;
}

.card {
    border-radius: 12px !important;
    border: none;
}

.btn {
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

@endsection