@extends('layouts.app')

@section('title', 'Gestión de Mascotas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #0369a1 100%); border-radius: 0.5rem 0.5rem 0 0;">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-dog me-2" style="color: #fbbf24;"></i> Gestión de Mascotas Donantes
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
                                           placeholder="Buscar por nombre de mascota o tutor..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="species" class="form-select">
                                    <option value="">Todas las especies</option>
                                    <option value="perro" {{ request('species') === 'perro' ? 'selected' : '' }}>Perro</option>
                                    <option value="gato" {{ request('species') === 'gato' ? 'selected' : '' }}>Gato</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn fw-semibold" style="background: #1e3a8a; border: none; color: white; border-radius: 0.5rem; transition: all 0.3s ease;" onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#1e3a8a'">
                                    <i class="fas fa-filter me-1"></i> Filtrar
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.pets') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Estadísticas rápidas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-white shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); border: none; border-radius: 1rem;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clock fa-2x me-3" style="opacity: 0.9;"></i>
                                        <div>
                                            <h5 class="mb-0 fw-bold">{{ $pets->where('donor_status', 'pending')->count() }}</h5>
                                            <small style="opacity: 0.9;">Pendientes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white shadow-sm" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border: none; border-radius: 1rem;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check fa-2x me-3" style="opacity: 0.9;"></i>
                                        <div>
                                            <h5 class="mb-0 fw-bold">{{ $pets->where('donor_status', 'approved')->count() }}</h5>
                                            <small style="opacity: 0.9;">Aprobados</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none; border-radius: 1rem;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-dog fa-2x me-3" style="opacity: 0.9;"></i>
                                        <div>
                                            <h5 class="mb-0 fw-bold">{{ $pets->where('species', 'perro')->count() }}</h5>
                                            <small style="opacity: 0.9;">Perros</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white shadow-sm" style="background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%); border: none; border-radius: 1rem;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-cat fa-2x me-3" style="opacity: 0.9;"></i>
                                        <div>
                                            <h5 class="mb-0 fw-bold">{{ $pets->where('species', 'gato')->count() }}</h5>
                                            <small style="opacity: 0.9;">Gatos</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de mascotas -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;">
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Mascota</th>
                                    <th>Tutor</th>
                                    <th>Especie</th>
                                    <th>Edad/Peso</th>
                                    <th>Tipo Sangre</th>
                                    <th>Estado</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
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
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.pets.show', $pet->id) }}"
                                               class="btn btn-sm btn-info" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.pets.edit', $pet->id) }}"
                                               class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('admin.pets.destroy', $pet->id) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar esta mascota?')">
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