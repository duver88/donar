@extends('layouts.app')

@section('title', 'Gestión de Solicitudes')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Solicitudes de Sangre
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Administrar solicitudes de donación de sangre canina y felina
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="card-body p-4">

                {{-- Filtros --}}
                <form method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0" style="color: #43883D;">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" name="search"
                                       placeholder="Buscar por paciente, tipo de sangre o veterinario..."
                                       value="{{ request('search') }}"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select" style="border-radius: 8px;">
                                <option value="">Todos los estados</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activa</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirada</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="urgency" class="form-select" style="border-radius: 8px;">
                                <option value="">Todas las urgencias</option>
                                <option value="baja" {{ request('urgency') === 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ request('urgency') === 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ request('urgency') === 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="critica" {{ request('urgency') === 'critica' ? 'selected' : '' }}>Crítica</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn w-100"
                                    style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.blood_requests') }}" class="btn w-100"
                               style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-refresh me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Estadísticas --}}
                <div class="row g-3 mb-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #43883D;">
                                    {{ $requests->where('status', 'active')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Solicitudes Activas</p>
                                @if($requests->where('status', 'active')->count() > 0)
                                    <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem;">
                                        Urgentes
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #93C01F;">
                                    {{ $requests->where('status', 'completed')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Completadas</p>
                                <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem;">
                                    Exitosas
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #C20E1A;">
                                    {{ $requests->where('urgency_level', 'critica')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Críticas</p>
                                @if($requests->where('urgency_level', 'critica')->count() > 0)
                                    <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem;">
                                        Máxima prioridad
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #F8DC0B;">
                                    {{ $requests->total() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Total Solicitudes</p>
                                <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem;">
                                    Historial completo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabla de solicitudes --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: #43883D;">
                            <tr>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">ID</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Paciente</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Veterinario</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Tipo Sangre</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Urgencia</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Estado</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Fecha Creación</th>
                                <th style="color: white; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Acciones</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse($requests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $request->patient_name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $request->patient_species ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($request->veterinarian)
                                            <div>
                                                <strong>Dr. {{ $request->veterinarian->name }}</strong>
                                                <br>
                                                @if($request->veterinarian->veterinarian)
                                                    <small class="text-muted">
                                                        <i class="fas fa-hospital me-1"></i>{{ $request->veterinarian->veterinarian->clinic_name ?? 'N/A' }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-id-card me-1"></i>{{ $request->veterinarian->veterinarian->professional_card ?? 'N/A' }}
                                                    </small>
                                                @else
                                                    <small class="text-muted">Perfil de veterinario no encontrado</small>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">No asignado</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem; font-weight: 500;">
                                            {{ $request->blood_type ?? $request->blood_type_needed }}
                                        </span>
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
                                        @if($request->status === 'active' && $request->needed_by_date && $request->needed_by_date < now())
                                            <div class="mt-1">
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> ¡Requiere atención!
                                                </small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $request->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.blood_requests.show', $request->id) }}"
                                               class="btn btn-sm"
                                               style="background: #43883D; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm"
                                                    style="background: #F8DC0B; color: #43883D; border: none; border-radius: 6px; padding: 6px 12px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateStatusModal{{ $request->id }}"
                                                    title="Cambiar estado">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-tint fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No se encontraron solicitudes</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $requests->withQueryString()->links() }}
                    </div>
            </div>
        </div>
    </div>
</div>

{{-- Modales para cambio de estado --}}
@foreach($requests as $request)
<div class="modal fade" id="updateStatusModal{{ $request->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #43883D; color: white; border-radius: 12px 12px 0 0; border: none;">
                <h5 class="modal-title" id="updateStatusModalLabel{{ $request->id }}">
                    <i class="fas fa-exchange-alt me-2"></i> Cambiar Estado - {{ $request->patient_name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form method="POST" action="{{ route('admin.blood_requests.update_status', $request->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="alert" style="border-radius: 8px; border: none; background: rgba(67, 136, 61, 0.1);">
                        <div class="d-flex align-items-center">
                            <div style="color: #43883D;">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Estado actual:</strong>
                                @switch($request->status)
                                    @case('active')
                                        <span class="badge ms-2" style="background: rgba(67, 136, 61, 0.2); color: #43883D;">Activa</span>
                                        @break
                                    @case('completed')
                                        <span class="badge ms-2" style="background: rgba(147, 192, 31, 0.2); color: #93C01F;">Completada</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge ms-2" style="background: rgba(108, 117, 125, 0.2); color: #6c757d;">Cancelada</span>
                                        @break
                                    @case('expired')
                                        <span class="badge ms-2" style="background: rgba(194, 14, 26, 0.2); color: #C20E1A;">Expirada</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status{{ $request->id }}" class="form-label" style="color: #43883D; font-weight: 500;">Nuevo Estado *</label>
                        <select class="form-select" name="status" id="status{{ $request->id }}" required
                                style="border-radius: 8px; border: 1px solid #e3e6f0; padding: 12px 16px;">
                            <option value="">-Seleccione nuevo estado-</option>
                            <option value="active" {{ $request->status === 'active' ? 'selected' : '' }}>Activa</option>
                            <option value="completed" {{ $request->status === 'completed' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelled" {{ $request->status === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                            <option value="expired" {{ $request->status === 'expired' ? 'selected' : '' }}>Expirada</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes{{ $request->id }}" class="form-label" style="color: #43883D; font-weight: 500;">Notas del Administrador</label>
                        <textarea class="form-control" name="admin_notes" id="admin_notes{{ $request->id }}" rows="4"
                                  placeholder="Motivo del cambio de estado, observaciones adicionales..."
                                  style="border-radius: 8px; border: 1px solid #e3e6f0; padding: 12px 16px;">{{ $request->admin_notes ?? '' }}</textarea>
                        <small class="text-muted">Esta información se guardará en el historial de la solicitud.</small>
                    </div>
                </div>
                <div class="modal-footer" style="border: none; background: #fafafa; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                            style="background: transparent; color: #6c757d; border: 1px solid #6c757d; border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn"
                            style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500;">
                        <i class="fas fa-save me-2"></i> Actualizar Estado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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

.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #43883D;
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #285F19;
}

.badge {
    border-radius: 6px;
    font-weight: 500;
}
</style>
@endsection