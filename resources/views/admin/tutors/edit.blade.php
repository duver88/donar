@extends('layouts.app')

@section('title', 'Editar Tutor')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Editar Tutor
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Actualizar información del tutor: {{ $tutor->name }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.tutors') }}"
                       class="btn"
                       style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.tutors.update', $tutor->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Información Personal --}}
                            <div class="mb-4">
                                <h5 class="fw-medium border-bottom pb-2" style="color: #43883D; border-color: #e9ecef !important;">
                                    <i class="fas fa-user me-2"></i> Información Personal
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre Completo *</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ old('name', $tutor->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{ old('email', $tutor->email) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono *</label>
                                    <input type="text" class="form-control" name="phone" id="phone"
                                           value="{{ old('phone', $tutor->phone) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="document_id" class="form-label">Número de Documento</label>
                                    <input type="text" class="form-control" name="document_id" id="document_id"
                                           value="{{ old('document_id', $tutor->document_id) }}">
                                    <div class="form-text">Opcional</div>
                                </div>
                            </div>

                            {{-- Información Adicional --}}
                            <div class="mb-4 mt-4">
                                <h5 class="fw-medium border-bottom pb-2" style="color: #43883D; border-color: #e9ecef !important;">
                                    <i class="fas fa-info-circle me-2"></i> Información Adicional
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 8px;">
                                        <div class="card-body text-center">
                                            <h4 class="fw-light mb-1" style="color: #43883D;">{{ $tutor->pets->count() }}</h4>
                                            <small class="text-muted">Mascotas Registradas</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 8px;">
                                        <div class="card-body text-center">
                                            <h4 class="fw-light mb-1" style="color: #285F19;">
                                                {{ $tutor->pets->where('donor_status', 'approved')->count() }}
                                            </h4>
                                            <small class="text-muted">Donantes Aprobados</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-0 h-100" style="background: #f8f9fa; border-radius: 8px;">
                                        <div class="card-body text-center">
                                            <h4 class="fw-light mb-1" style="color: #6c757d;">
                                                {{ $tutor->created_at->format('d/m/Y') }}
                                            </h4>
                                            <small class="text-muted">Fecha de Registro</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mascotas del Tutor --}}
                            @if($tutor->pets->count() > 0)
                                <div class="mb-4">
                                    <h5 class="fw-medium border-bottom pb-2" style="color: #43883D; border-color: #e9ecef !important;">
                                        <i class="fas fa-paw me-2"></i> Mascotas Registradas
                                    </h5>
                                </div>

                                <div class="table-responsive mb-4">
                                    <table class="table table-sm">
                                        <thead style="background: #f8f9fa;">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Especie</th>
                                                <th>Tipo de Sangre</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tutor->pets as $pet)
                                                <tr>
                                                    <td>{{ $pet->name }}</td>
                                                    <td>{{ ucfirst($pet->species) }}</td>
                                                    <td>
                                                        @if($pet->blood_type)
                                                            <span class="badge bg-info">{{ $pet->blood_type }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'approved' => 'success',
                                                                'pending' => 'warning',
                                                                'rejected' => 'danger'
                                                            ];
                                                            $color = $statusColors[$pet->donor_status] ?? 'secondary';
                                                        @endphp
                                                        <span class="badge bg-{{ $color }}">
                                                            {{ $pet->status_display }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.pets.show', $pet->id) }}"
                                                           class="btn btn-sm btn-outline-primary"
                                                           title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn flex-fill"
                                        style="background: #43883D; color: white; border: none; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='#285F19'"
                                        onmouseout="this.style.background='#43883D'">
                                    <i class="fas fa-save me-2"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('admin.tutors') }}" class="btn"
                                   style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </a>
                            </div>
                        </form>
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
</style>
@endsection
