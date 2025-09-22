@extends('layouts.app')

@section('title', 'Gestión de Veterinarios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-md"></i> Gestión de Veterinarios
                    </h4>
                    <a href="{{ route('admin.veterinarians.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Veterinario
                    </a>
                </div>
                <div class="card-body">

                    <!-- Filtros -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="search"
                                           placeholder="Buscar por nombre o email..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('admin.veterinarians') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Estadísticas rápidas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $veterinarians->where('status', 'pending')->count() }}</h5>
                                            <small>Pendientes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $veterinarians->where('status', 'approved')->count() }}</h5>
                                            <small>Aprobados</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-times fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $veterinarians->where('status', 'rejected')->count() }}</h5>
                                            <small>Rechazados</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users fa-2x me-3"></i>
                                        <div>
                                            <h5 class="mb-0">{{ $veterinarians->total() }}</h5>
                                            <small>Total</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de veterinarios -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Licencia</th>
                                    <th>Clínica</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($veterinarians as $veterinarian)
                                <tr>
                                    <td>{{ $veterinarian->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-md text-primary me-2"></i>
                                            <strong>{{ $veterinarian->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $veterinarian->email }}</td>
                                    <td>{{ $veterinarian->phone ?? 'N/A' }}</td>
                                    <td>{{ $veterinarian->veterinarian->professional_card ?? 'N/A' }}</td>
                                    <td>{{ $veterinarian->veterinarian->clinic_name ?? 'N/A' }}</td>
                                    <td>
                                        @switch($veterinarian->status)
                                            @case('pending')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock"></i> Pendiente
                                                </span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Aprobado
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Rechazado
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>{{ $veterinarian->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.veterinarians.show', $veterinarian->id) }}"
                                               class="btn btn-sm btn-primary" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($veterinarian->status === 'pending')
                                                <a href="{{ route('admin.veterinarians.review', $veterinarian->id) }}"
                                                   class="btn btn-sm btn-info" title="Revisar Solicitud">
                                                    <i class="fas fa-clipboard-check"></i>
                                                </a>
                                            @endif

                                            <a href="{{ route('admin.veterinarians.edit', $veterinarian->id) }}"
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.veterinarians.destroy', $veterinarian->id) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este veterinario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No se encontraron veterinarios</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $veterinarians->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection