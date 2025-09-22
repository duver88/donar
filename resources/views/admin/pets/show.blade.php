@extends('layouts.app')

@section('title', 'Detalles de ' . $pet->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }}"></i>
                        Detalles de {{ $pet->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($pet->photo_path)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $pet->photo_path) }}"
                                         alt="Foto de {{ $pet->name }}"
                                         class="img-fluid rounded mb-3 shadow-sm cursor-pointer"
                                         style="max-height: 300px; width: 100%; object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#photoModal"
                                         title="Click para ver en tamaño completo">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-dark bg-opacity-75">
                                            <i class="fas fa-expand"></i> Ver grande
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3"
                                     style="height: 200px;">
                                    <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }} fa-4x text-white"></i>
                                </div>
                                <p class="text-muted text-center">
                                    <i class="fas fa-camera-slash"></i> Sin foto disponible
                                </p>
                            @endif

                            <div class="text-center">
                                @switch($pet->donor_status ?? $pet->status)
                                    @case('pending')
                                        <span class="badge bg-warning fs-6">
                                            <i class="fas fa-clock"></i> Pendiente
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-check"></i> Aprobado
                                        </span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger fs-6">
                                            <i class="fas fa-times"></i> Rechazado
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>

                        <div class="col-md-8">
                            <h3>{{ $pet->name }}</h3>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Especie:</strong>
                                    <span class="badge bg-{{ $pet->species === 'perro' ? 'primary' : 'info' }}">
                                        <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }}"></i>
                                        {{ ucfirst($pet->species) }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <strong>Raza:</strong> {{ $pet->breed }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Edad:</strong> {{ $pet->age_years ?? $pet->age ?? 'N/A' }} años
                                </div>
                                <div class="col-6">
                                    <strong>Peso:</strong> {{ $pet->weight_kg ?? $pet->weight ?? 'N/A' }} kg
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Tipo de Sangre:</strong>
                                    <span class="badge bg-light text-dark">
                                        {{ $pet->blood_type ?? 'No determinado' }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <strong>Estado de Salud:</strong>
                                    <span class="badge bg-{{ $pet->health_status === 'excelente' ? 'success' : ($pet->health_status === 'bueno' ? 'primary' : 'warning') }}">
                                        {{ ucfirst($pet->health_status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Vacunas al día:</strong>
                                    @if($pet->vaccines_up_to_date ?? $pet->vaccination_status)
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Sí</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> No</span>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <strong>Ha donado antes:</strong>
                                    @if($pet->has_donated_before)
                                        <span class="badge bg-info"><i class="fas fa-check"></i> Sí</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-times"></i> No</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Fecha de registro:</strong> {{ $pet->created_at->format('d/m/Y H:i') }}
                            </div>

                            @if($pet->approved_at)
                            <div class="mb-3">
                                <strong>Fecha de aprobación:</strong> {{ $pet->approved_at->format('d/m/Y H:i') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Información del Tutor -->
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> Información del Tutor
                    </h5>
                </div>
                <div class="card-body">
                    @if($pet->user)
                        <div class="mb-2">
                            <strong>Nombre:</strong><br>
                            {{ $pet->user->name }}
                        </div>
                        <div class="mb-2">
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $pet->user->email }}">{{ $pet->user->email }}</a>
                        </div>
                        <div class="mb-2">
                            <strong>Teléfono:</strong><br>
                            @if($pet->user->phone)
                                <a href="tel:{{ $pet->user->phone }}">{{ $pet->user->phone }}</a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <strong>Documento:</strong><br>
                            {{ $pet->user->document_id ?? 'No disponible' }}
                        </div>
                    @else
                        <div class="text-muted">
                            <i class="fas fa-exclamation-triangle"></i>
                            Información del tutor no disponible
                        </div>
                    @endif
                </div>
            </div>

            <!-- Condiciones de Salud -->
            @php
                $hasHealthConditions = false;
                try {
                    $hasHealthConditions = $pet->healthConditions && $pet->healthConditions->count() > 0;
                } catch (\Exception $e) {
                    $hasHealthConditions = false;
                }
            @endphp

            @if($hasHealthConditions)
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-stethoscope"></i> Condiciones de Salud Registradas
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($pet->healthConditions as $condition)
                        <div class="mb-3 p-3 border rounded">
                            <h6 class="text-primary">{{ $condition->condition_type ?? 'Condición de Salud' }}</h6>
                            <div class="mb-2">
                                <strong>Estado:</strong>
                                @if($condition->has_condition)
                                    <span class="badge bg-danger"><i class="fas fa-exclamation-triangle"></i> Sí tiene esta condición</span>
                                @else
                                    <span class="badge bg-success"><i class="fas fa-check"></i> No tiene esta condición</span>
                                @endif
                            </div>
                            @if($condition->notes)
                            <div class="mb-2">
                                <strong>Notas:</strong>
                                <p class="mb-0 text-muted">{{ $condition->notes }}</p>
                            </div>
                            @endif
                            <small class="text-muted">
                                Registrado: {{ $condition->created_at ? $condition->created_at->format('d/m/Y H:i') : 'Fecha no disponible' }}
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Condiciones de Salud
                    </h5>
                </div>
                <div class="card-body text-center py-4">
                    <i class="fas fa-heartbeat fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Sin información de condiciones de salud registrada</h6>
                    <p class="text-muted mb-0">Esta mascota no tiene condiciones de salud específicas registradas en el sistema.</p>
                </div>
            </div>
            @endif

            <!-- Acciones -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs"></i> Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.pets.edit', $pet->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Mascota
                        </a>

                        <form method="POST" action="{{ route('admin.pets.destroy', $pet->id) }}"
                              onsubmit="return confirm('¿Estás seguro de eliminar esta mascota?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Eliminar Mascota
                            </button>
                        </form>

                        <a href="{{ route('admin.pets') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($pet->photo_path)
<!-- Modal para mostrar la foto en grande -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">
                    <i class="fas fa-camera"></i> Foto de {{ $pet->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $pet->photo_path) }}"
                         alt="Foto de {{ $pet->name }}"
                         class="img-fluid w-100"
                         style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Foto de {{ $pet->name }} - {{ ucfirst($pet->species) }}, {{ $pet->breed }}
                        </small>
                    </div>
                    <div>
                        <a href="{{ asset('storage/' . $pet->photo_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                        </a>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection