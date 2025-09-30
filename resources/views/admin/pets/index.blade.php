@extends('layouts.app')

@section('title', 'Gestión de Mascotas')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Gestión de Mascotas
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Administrar donantes caninos y felinos
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
                                       placeholder="Buscar por nombre de mascota o tutor..."
                                       value="{{ request('search') }}"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select" style="border-radius: 8px;">
                                <option value="">Todos los estados</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="species" class="form-select" style="border-radius: 8px;">
                                <option value="">Todas las especies</option>
                                <option value="perro" {{ request('species') === 'perro' ? 'selected' : '' }}>Perro</option>
                                <option value="gato" {{ request('species') === 'gato' ? 'selected' : '' }}>Gato</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn w-100"
                                    style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.pets') }}" class="btn w-100"
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
                                    {{ $pets->where('donor_status', 'pending')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Pendientes</p>
                                @if($pets->where('donor_status', 'pending')->count() > 0)
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
                                    {{ $pets->where('donor_status', 'approved')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Aprobados</p>
                                <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem;">
                                    Donantes activos
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #93C01F;">
                                    {{ $pets->where('species', 'perro')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Perros</p>
                                <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem;">
                                    Caninos
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #C20E1A;">
                                    {{ $pets->where('species', 'gato')->count() }}
                                </h2>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">Gatos</p>
                                <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem;">
                                    Felinos
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabla de mascotas --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead style="background: #f8f9fa; border-bottom: 2px solid #43883D;">
                            <tr>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">ID</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Foto</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Mascota</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Tutor</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Especie</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Edad/Peso</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Tipo Sangre</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Estado</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Fecha Registro</th>
                                <th style="color: #; font-weight: 600; font-size: 0.9rem; padding: 1rem;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($pets as $pet)
                                <tr>
                                    <td>{{ $pet->id }}</td>
                                    <td>
                                        @if($pet->photo_path)
                                            <img src="{{ asset('storage/' . $pet->photo_path) }}"
                                                 alt="Foto de {{ $pet->name }}"
                                                 class="rounded-circle"
                                                 width="40" height="40"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }} text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $pet->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $pet->breed }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $pet->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $pet->user->email ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $pet->species === 'perro' ? 'primary' : 'info' }}">
                                            <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }}"></i>
                                            {{ ucfirst($pet->species) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            <strong>{{ $pet->age_years ?? $pet->age ?? 'N/A' }}</strong> años<br>
                                            <strong>{{ $pet->weight_kg ?? $pet->weight ?? 'N/A' }}</strong> kg
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $pet->blood_type ?? 'No determinado' }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($pet->donor_status ?? $pet->status)
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
                                    <td>{{ $pet->created_at->format('d/m/Y') }}</td>
                                    <td style="padding: 1rem;">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.pets.show', $pet->id) }}"
                                               class="btn btn-sm"
                                               style="background: #43883D; color: white; border: none; border-radius: 6px; padding: 6px 12px;"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.pets.edit', $pet->id) }}"
                                               class="btn btn-sm"
                                               style="background: #F8DC0B; color: #43883D; border: none; border-radius: 6px; padding: 6px 12px;"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.pets.destroy', $pet->id) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar esta mascota?')">
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
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fas fa-dog fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No se encontraron mascotas</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $pets->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection