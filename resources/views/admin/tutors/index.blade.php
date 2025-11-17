@extends('layouts.app')

@section('title', 'Gestión de Tutores')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Gestión de Tutores
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Administrar dueños de mascotas donantes
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}"
                       class="btn"
                       style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="card-body p-4">

                {{-- Mensajes --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Filtros --}}
                <form method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0" style="color: #43883D;">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" name="search"
                                       placeholder="Buscar por nombre, email, teléfono o documento..."
                                       value="{{ request('search') }}"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn w-100"
                                    style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-filter me-1"></i> Buscar
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.tutors') }}" class="btn w-100"
                               style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-weight: 500;">
                                <i class="fas fa-refresh me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Estadísticas --}}
                <div class="row g-3 mb-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #43883D;">
                                    {{ $tutors->total() }}
                                </h2>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Total de Tutores</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #285F19;">
                                    {{ $tutors->sum(fn($t) => $t->pets->count()) }}
                                </h2>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Mascotas Registradas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #F8DC0B;">
                                    {{ $tutors->sum(fn($t) => $t->pets->where('donor_status', 'approved')->count()) }}
                                </h2>
                                <p class="text-muted mb-0" style="font-size: 0.9rem;">Donantes Aprobados</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="border: none; color: #43883D; font-weight: 600;">Tutor</th>
                                <th style="border: none; color: #43883D; font-weight: 600;">Contacto</th>
                                <th style="border: none; color: #43883D; font-weight: 600;">Documento</th>
                                <th style="border: none; color: #43883D; font-weight: 600;">Mascotas</th>
                                <th style="border: none; color: #43883D; font-weight: 600;">Registro</th>
                                <th style="border: none; color: #43883D; font-weight: 600; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tutors as $tutor)
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 45px; height: 45px;">
                                                <i class="fas fa-user" style="color: #43883D; font-size: 1.2rem;"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium" style="color: #2c3e50;">{{ $tutor->name }}</div>
                                                <small class="text-muted">ID: #{{ $tutor->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.9rem;">
                                            <div class="mb-1">
                                                <i class="fas fa-envelope text-muted me-2"></i>{{ $tutor->email }}
                                            </div>
                                            <div>
                                                <i class="fas fa-phone text-muted me-2"></i>{{ $tutor->phone }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($tutor->document_id)
                                            <span class="badge bg-light text-dark">{{ $tutor->document_id }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-primary">{{ $tutor->pets->count() }} total</span>
                                            @if($tutor->pets->where('donor_status', 'approved')->count() > 0)
                                                <span class="badge" style="background: #43883D;">
                                                    {{ $tutor->pets->where('donor_status', 'approved')->count() }} aprobados
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $tutor->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.tutors.edit', $tutor->id) }}"
                                               class="btn btn-sm"
                                               style="background: #43883D; color: white; border-radius: 6px;"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.tutors.destroy', $tutor->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este tutor?');">
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
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                            <p class="mb-0">No se encontraron tutores</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($tutors->hasPages())
                    <div class="mt-4">
                        {{ $tutors->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- Estilos --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');

* {
    font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.table tbody tr:hover {
    background-color: rgba(67, 136, 61, 0.05);
    transition: background-color 0.2s ease;
}
</style>
@endsection
