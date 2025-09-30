@extends('layouts.app')

@section('title', 'Solicitud #' . $request->id)

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Solicitud #{{ $request->id }}
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Paciente: <strong>{{ $request->patient_name }}</strong> • Tipo de sangre: <strong>{{ $request->blood_type ?? $request->blood_type_needed }}</strong>
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.blood_requests') }}"
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
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        {{-- Información del Paciente --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-paw me-2"></i> Información del Paciente
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Nombre del paciente</small>
                                        <strong style="color: #43883D;">{{ $request->patient_name }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Especie</small>
                                        <strong style="color: #43883D;">{{ ucfirst($request->patient_species ?? 'No especificado') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Raza</small>
                                        <strong style="color: #43883D;">{{ $request->patient_breed ?? 'No especificado' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Edad</small>
                                        <strong style="color: #43883D;">{{ $request->patient_age ?? 'N/A' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Peso</small>
                                        <strong style="color: #43883D;">{{ $request->patient_weight ?? 'N/A' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Detalles de la Solicitud --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-tint me-2"></i> Detalles de la Solicitud
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Tipo de Sangre</small>
                                        <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.9rem; font-weight: 500;">
                                            {{ $request->blood_type ?? $request->blood_type_needed }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Cantidad Necesaria</small>
                                        <strong style="color: #43883D;">{{ $request->quantity_needed ?? 'No especificado' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Nivel de Urgencia</small>
                                        @switch($request->urgency_level)
                                            @case('critica')
                                                <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.9rem; font-weight: 500;">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> Crítica
                                                </span>
                                                @break
                                            @case('alta')
                                                <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.9rem; font-weight: 500;">
                                                    <i class="fas fa-exclamation me-1"></i> Alta
                                                </span>
                                                @break
                                            @case('media')
                                                <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.9rem; font-weight: 500;">
                                                    <i class="fas fa-info me-1"></i> Media
                                                </span>
                                                @break
                                            @case('baja')
                                                <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.9rem; font-weight: 500;">
                                                    <i class="fas fa-minus me-1"></i> Baja
                                                </span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Estado y Fechas --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-info-circle me-2"></i> Estado y Fechas
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Estado Actual</small>
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
                                <div class="col-md-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Fecha de Creación</small>
                                        <strong style="color: #43883D;">{{ $request->created_at->format('d/m/Y H:i') }}</strong>
                                    </div>
                                </div>
                                @if($request->completed_at)
                                <div class="col-md-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Fecha de Completado</small>
                                        <strong style="color: #43883D;">{{ $request->completed_at->format('d/m/Y H:i') }}</strong>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                        @if($request->medical_reason)
                        {{-- Razón Médica --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-notes-medical me-2"></i> Razón Médica
                            </h5>
                            <div class="p-4 rounded" style="background: rgba(67, 136, 61, 0.05); border-left: 4px solid #43883D;">
                                <p class="mb-0" style="line-height: 1.6;">{{ $request->medical_reason }}</p>
                            </div>
                        </div>
                        @endif

                        @if($request->additional_notes)
                        {{-- Notas Adicionales --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-sticky-note me-2"></i> Notas Adicionales
                            </h5>
                            <div class="p-4 rounded" style="background: rgba(147, 192, 31, 0.05); border-left: 4px solid #93C01F;">
                                <p class="mb-0" style="line-height: 1.6;">{{ $request->additional_notes }}</p>
                            </div>
                        </div>
                        @endif

                        @if($request->admin_notes)
                        {{-- Notas del Administrador --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #F8DC0B; border-color: #e9ecef !important;">
                                <i class="fas fa-user-shield me-2"></i> Notas del Administrador
                            </h5>
                            <div class="p-4 rounded" style="background: rgba(248, 220, 11, 0.05); border-left: 4px solid #F8DC0B;">
                                <p class="mb-0" style="line-height: 1.6; font-weight: 500;">{{ $request->admin_notes }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Respuestas de donación --}}
                        @if($request->donationResponses->count() > 0)
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-reply me-2"></i> Respuestas de Donantes ({{ $request->donationResponses->count() }})
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-hover" style="border-radius: 8px; overflow: hidden;">
                                    <thead style="background: #f8f9fa;">
                                        <tr>
                                            <th style="color: #43883D; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Mascota</th>
                                            <th style="color: #43883D; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Tutor</th>
                                            <th style="color: #43883D; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Respuesta</th>
                                            <th style="color: #43883D; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Fecha</th>
                                            <th style="color: #43883D; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Estado</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    @foreach($request->donationResponses as $response)
                                    <tr style="border-bottom: 1px solid #f1f3f4;">
                                        <td style="padding: 1rem;">
                                            <strong style="color: #43883D;">{{ $response->pet->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $response->pet->breed ?? 'N/A' }}</small>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <strong style="color: #43883D;">{{ $response->pet->user->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $response->pet->user->email ?? 'N/A' }}</small>
                                        </td>
                                        <td style="padding: 1rem;">
                                            @if($response->response === 'accepted')
                                                <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem; font-weight: 500;">
                                                    <i class="fas fa-check me-1"></i> Aceptada
                                                </span>
                                            @else
                                                <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem; font-weight: 500;">
                                                    <i class="fas fa-times me-1"></i> Rechazada
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem;">{{ $response->created_at->format('d/m/Y H:i') }}</td>
                                        <td style="padding: 1rem;">
                                            @switch($response->status)
                                                @case('pending')
                                                    <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem; font-weight: 500;">
                                                        Pendiente
                                                    </span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem; font-weight: 500;">
                                                        Completada
                                                    </span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.75rem; font-weight: 500;">
                                                        Cancelada
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Información del Veterinario --}}
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D;">
                            <i class="fas fa-user-md me-2"></i> Veterinario Responsable
                        </h5>
                        @if($request->veterinarian)
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Nombre</small>
                                <strong style="color: #43883D;">Dr. {{ $request->veterinarian->name }}</strong>
                            </div>
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Email</small>
                                <a href="mailto:{{ $request->veterinarian->email }}" style="color: #43883D; text-decoration: none;">
                                    {{ $request->veterinarian->email }}
                                </a>
                            </div>
                            @if($request->veterinarian->phone)
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Teléfono</small>
                                <a href="tel:{{ $request->veterinarian->phone }}" style="color: #43883D; text-decoration: none;">
                                    {{ $request->veterinarian->phone }}
                                </a>
                            </div>
                            @else
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Teléfono</small>
                                <span class="text-muted">No disponible</span>
                            </div>
                            @endif

                            @if($request->veterinarian->veterinarian)
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Tarjeta Profesional</small>
                                <strong style="color: #43883D;">{{ $request->veterinarian->veterinarian->professional_card ?? 'No disponible' }}</strong>
                            </div>
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Especialidad</small>
                                <strong style="color: #43883D;">{{ $request->veterinarian->veterinarian->specialty ?? 'No disponible' }}</strong>
                            </div>
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Clínica</small>
                                <strong style="color: #43883D;">{{ $request->veterinarian->veterinarian->clinic_name ?? 'No disponible' }}</strong>
                            </div>
                            @if($request->veterinarian->veterinarian->clinic_address)
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Dirección</small>
                                <span style="color: #43883D;">{{ $request->veterinarian->veterinarian->clinic_address }}</span>
                            </div>
                            @endif
                            <div class="mb-3 p-3 rounded" style="background: #f8f9fa;">
                                <small class="text-muted d-block">Ciudad</small>
                                <strong style="color: #43883D;">{{ $request->veterinarian->veterinarian->city ?? 'No disponible' }}</strong>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #6c757d;"></i>
                                <p class="text-muted mt-2 mb-0">Información del veterinario no disponible</p>
                            </div>
                        @endif
                </div>
            </div>

                {{-- Cambiar Estado --}}
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #F8DC0B;">
                            <i class="fas fa-exchange-alt me-2"></i> Cambiar Estado
                        </h5>
                        <form method="POST" action="{{ route('admin.blood_requests.update_status', $request->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="status" class="form-label" style="color: #43883D; font-weight: 500;">Estado Actual:
                                    @switch($request->status)
                                        @case('active')
                                            <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D;">Activa</span>
                                            @break
                                        @case('completed')
                                            <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F;">Completada</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge" style="background: rgba(108, 117, 125, 0.1); color: #6c757d;">Cancelada</span>
                                            @break
                                        @case('expired')
                                            <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A;">Expirada</span>
                                            @break
                                    @endswitch
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label" style="color: #43883D; font-weight: 500;">Nuevo Estado *</label>
                                <select class="form-select" name="status" id="status" required
                                        style="border-radius: 8px; border: 1px solid #e3e6f0; padding: 12px 16px;">
                                    <option value="">-Seleccione-</option>
                                    <option value="active" {{ $request->status === 'active' ? 'selected' : '' }}>Activa</option>
                                    <option value="completed" {{ $request->status === 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelled" {{ $request->status === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                    <option value="expired" {{ $request->status === 'expired' ? 'selected' : '' }}>Expirada</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="admin_notes" class="form-label" style="color: #43883D; font-weight: 500;">Notas del Administrador</label>
                                <textarea class="form-control" name="admin_notes" id="admin_notes" rows="4"
                                          placeholder="Motivo del cambio de estado..."
                                          style="border-radius: 8px; border: 1px solid #e3e6f0; padding: 12px 16px;">{{ $request->admin_notes ?? '' }}</textarea>
                            </div>

                            @if($request->status !== 'active')
                            <div class="alert alert-warning" style="border-radius: 8px; border: none; background: rgba(248, 220, 11, 0.1);">
                                <i class="fas fa-exclamation-triangle me-2" style="color: #F8DC0B;"></i>
                                <small style="color: #43883D;">
                                    <strong>Atención:</strong> Esta solicitud ya fue {{ $request->status === 'completed' ? 'completada' : ($request->status === 'cancelled' ? 'cancelada' : 'expirada') }}.
                                    Puedes cambiar el estado si fue un error.
                                </small>
                            </div>
                            @endif

                            <div class="d-grid">
                                <button type="submit" class="btn"
                                        style="background: #F8DC0B; color: #43883D; border: none; border-radius: 8px; font-weight: 500; padding: 12px;">
                                    <i class="fas fa-save me-2"></i> Actualizar Estado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Acciones Generales --}}
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D;">
                            <i class="fas fa-tools me-2"></i> Acciones
                        </h5>
                        <div class="d-grid gap-3">
                            @if($request->veterinarian)
                            <a href="mailto:{{ $request->veterinarian->email }}" class="btn"
                               style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px;">
                                <i class="fas fa-envelope me-2"></i> Contactar Veterinario
                            </a>
                            @endif

                            <a href="{{ route('admin.blood_requests') }}" class="btn"
                               style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-weight: 500; padding: 12px;">
                                <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                            </a>
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
    transition: all 0.2s ease;
}

.btn {
    font-weight: 500;
    transition: all 0.2s ease;
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

.badge {
    border-radius: 6px;
    font-weight: 500;
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Ubuntu', sans-serif;
}
</style>
@endsection