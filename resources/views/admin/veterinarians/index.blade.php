@extends('layouts.app')

@section('title', 'Gestión de Veterinarios')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Gestión de Veterinarios
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Administrar y revisar solicitudes de veterinarios
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.veterinarians.create') }}"
                       class="btn"
                       style="background: #43883D; color: white; border: none; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500; transition: all 0.2s ease;"
                       onmouseover="this.style.background='#285F19'"
                       onmouseout="this.style.background='#43883D'">
                        <i class="fas fa-plus me-2"></i> Nuevo Veterinario
                    </a>
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
                                       placeholder="Buscar por nombre o email..."
                                       value="{{ request('search') }}"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select" style="border-radius: 8px;">
                                <option value="">Todos los estados</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn w-100"
                                    style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.veterinarians') }}" class="btn w-100"
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
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #F8DC0B;">
                                    {{ $veterinarians->where('status', 'pending')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Pendientes</p>
                                @if($veterinarians->where('status', 'pending')->count() > 0)
                                    <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem;">
                                        Requieren revisión
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #43883D;">
                                    {{ $veterinarians->where('status', 'approved')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Aprobados</p>
                                <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem;">
                                    Activos
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #C20E1A;">
                                    {{ $veterinarians->where('status', 'rejected')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Rechazados</p>
                                <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem;">
                                    Inactivos
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #93C01F;">
                                    {{ $veterinarians->total() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Total</p>
                                <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem;">
                                    Registrados
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabla de veterinarios --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: #f8f9fa; border-bottom: 2px solid #43883D;">
                            <tr>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">ID</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Nombre</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Email</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Teléfono</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Licencia</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Clínica</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Estado</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Fecha Registro</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($veterinarians as $veterinarian)
                            <tr style="border-bottom: 1px solid #f1f3f4;">
                                <td style="padding: 1rem; color: #6c757d;">{{ $veterinarian->id }}</td>
                                <td style="padding: 1rem;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-md me-2" style="color: #43883D;"></i>
                                        <strong style="color: #43883D;">{{ $veterinarian->name }}</strong>
                                    </div>
                                </td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $veterinarian->email }}</td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $veterinarian->phone ?? 'N/A' }}</td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $veterinarian->veterinarian->professional_card ?? 'N/A' }}</td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $veterinarian->veterinarian->clinic_name ?? 'N/A' }}</td>
                                <td style="padding: 1rem;">
                                    @switch($veterinarian->status)
                                        @case('pending')
                                            <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem; font-weight: 500;">
                                                <i class="fas fa-clock me-1"></i> Pendiente
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem; font-weight: 500;">
                                                <i class="fas fa-check me-1"></i> Aprobado
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem; font-weight: 500;">
                                                <i class="fas fa-times me-1"></i> Rechazado
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $veterinarian->created_at->format('d/m/Y H:i') }}</td>
                                <td style="padding: 1rem;">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.veterinarians.show', $veterinarian->id) }}"
                                           class="btn btn-sm"
                                           style="background: #43883D; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
                                           title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($veterinarian->status === 'pending')
                                            <a href="{{ route('admin.veterinarians.review', $veterinarian->id) }}"
                                               class="btn btn-sm"
                                               style="background: #93C01F; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
                                               title="Revisar Solicitud">
                                                <i class="fas fa-clipboard-check"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.veterinarians.edit', $veterinarian->id) }}"
                                           class="btn btn-sm"
                                           style="background: #F8DC0B; color: #43883D; border: none; border-radius: 6px; padding: 6px 12px;"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.veterinarians.destroy', $veterinarian->id) }}"
                                              style="display: inline;"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este veterinario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm"
                                                    style="background: #C20E1A; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-user-md" style="font-size: 3rem; color: #43883D;"></i>
                                    </div>
                                    <h6 class="fw-medium mb-2" style="color: #43883D;">No hay veterinarios</h6>
                                    <p class="text-muted small mb-0">No se encontraron veterinarios con los filtros seleccionados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $veterinarians->withQueryString()->links() }}
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
</style>
@endsection