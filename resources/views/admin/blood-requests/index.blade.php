@extends('layouts.app')

@section('title', 'Gestión de Solicitudes')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-tint"></i> Gestión de Solicitudes de Sangre
                    </h4>
                </div>
                <div class="card-body">

                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="search"
                                           placeholder="Buscar por paciente, tipo de sangre o veterinario..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activa</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirada</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="urgency" class="form-select">
                                    <option value="">Todas las urgencias</option>
                                    <option value="baja" {{ request('urgency') === 'baja' ? 'selected' : '' }}>Baja</option>
                                    <option value="media" {{ request('urgency') === 'media' ? 'selected' : '' }}>Media</option>
                                    <option value="alta" {{ request('urgency') === 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="critica" {{ request('urgency') === 'critica' ? 'selected' : '' }}>Crítica</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.blood_requests') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Estadísticas rápidas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-heartbeat fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $requests->where('status', 'active')->count() }}</h5>
                                            <small>Activas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $requests->where('status', 'completed')->count() }}</h5>
                                            <small>Completadas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $requests->where('urgency_level', 'critica')->count() }}</h5>
                                            <small>Críticas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-list fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $requests->total() }}</h5>
                                            <small>Total</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de solicitudes -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Paciente</th>
                                    <th>Veterinario</th>
                                    <th>Tipo Sangre</th>
                                    <th>Urgencia</th>
                                    <th>Estado</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
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
                                        <div>
                                            <strong>{{ $request->veterinarian->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $request->veterinarian->clinic_name ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-dark">
                                            {{ $request->blood_type }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($request->urgency_level)
                                            @case('critica')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> Crítica
                                                </span>
                                                @break
                                            @case('alta')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-exclamation"></i> Alta
                                                </span>
                                                @break
                                            @case('media')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-info"></i> Media
                                                </span>
                                                @break
                                            @case('baja')
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-minus"></i> Baja
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blood_requests.show', $request->id) }}"
                                               class="btn btn-sm btn-info" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($request->status === 'active')
                                                <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateStatusModal{{ $request->id }}"
                                                        title="Cambiar estado">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Modal para cambio de estado -->
                                        @if($request->status === 'active')
                                        <div class="modal fade" id="updateStatusModal{{ $request->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cambiar Estado - {{ $request->patient_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('admin.blood_requests.update_status', $request->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status{{ $request->id }}" class="form-label">Nuevo Estado *</label>
                                                                <select class="form-select" name="status" id="status{{ $request->id }}" required>
                                                                    <option value="completed">Completada</option>
                                                                    <option value="cancelled">Cancelada</option>
                                                                    <option value="expired">Expirada</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="admin_notes{{ $request->id }}" class="form-label">Notas del Administrador</label>
                                                                <textarea class="form-control" name="admin_notes" id="admin_notes{{ $request->id }}" rows="3"
                                                                          placeholder="Motivo del cambio de estado..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Actualizar Estado</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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
</div>
@endsection