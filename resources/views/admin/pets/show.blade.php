@extends('layouts.app')

@section('title', 'Detalles de ' . $pet->name)

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }} me-2"></i>
                        Detalles de {{ $pet->name }}
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        {{ ucfirst($pet->species) }} • {{ $pet->breed }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.pets') }}"
                       class="btn"
                       style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($pet->photo_path)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $pet->photo_path) }}"
                                             alt="Foto de {{ $pet->name }}"
                                             class="img-fluid rounded mb-3 cursor-pointer"
                                             style="max-height: 300px; width: 100%; object-fit: cover; cursor: pointer; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal"
                                             title="Click para ver en tamaño completo">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge" style="background: rgba(67, 136, 61, 0.9); color: white;">
                                                <i class="fas fa-expand"></i> Ver grande
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center justify-content-center mb-3"
                                         style="height: 200px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }} fa-4x" style="color: #43883D;"></i>
                                    </div>
                                    <p class="text-muted text-center">
                                        <i class="fas fa-camera-slash"></i> Sin foto disponible
                                    </p>
                                @endif

                                <div class="text-center mb-3">
                                    @switch($pet->donor_status ?? $pet->status)
                                        @case('pending')
                                            <span class="badge" style="background: #F8DC0B; color: #43883D; font-size: 0.9rem; padding: 8px 16px;">
                                                <i class="fas fa-clock"></i> Pendiente
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="badge" style="background: #43883D; color: white; font-size: 0.9rem; padding: 8px 16px;">
                                                <i class="fas fa-check"></i> Aprobado
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="badge" style="background: #C20E1A; color: white; font-size: 0.9rem; padding: 8px 16px;">
                                                <i class="fas fa-times"></i> Rechazado
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                            </div>

                            <div class="col-md-8">
                                {{-- Información básica --}}
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Especie</small>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-{{ $pet->species === 'perro' ? 'dog' : 'cat' }} me-2" style="color: #43883D;"></i>
                                                <strong style="color: #43883D;">{{ ucfirst($pet->species) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Raza</small>
                                            <strong style="color: #43883D;">{{ $pet->breed }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Edad</small>
                                            <strong style="color: #43883D;">{{ $pet->age_years ?? $pet->age ?? 'N/A' }} años</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Peso</small>
                                            <strong style="color: #43883D;">{{ $pet->weight_kg ?? $pet->weight ?? 'N/A' }} kg</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Información médica --}}
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Tipo de Sangre</small>
                                            <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; border: 1px solid #43883D;">
                                                {{ $pet->blood_type ?? 'No determinado' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Estado de Salud</small>
                                            <span class="badge" style="background: {{ $pet->health_status === 'excelente' ? '#43883D' : ($pet->health_status === 'bueno' ? '#93C01F' : '#F8DC0B') }}; color: {{ $pet->health_status === 'excelente' ? 'white' : ($pet->health_status === 'bueno' ? 'white' : '#43883D') }};">
                                                {{ ucfirst($pet->health_status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Vacunas al día</small>
                                            @if($pet->vaccines_up_to_date ?? $pet->vaccination_status)
                                                <span class="badge" style="background: #43883D; color: white;"><i class="fas fa-check"></i> Sí</span>
                                            @else
                                                <span class="badge" style="background: #C20E1A; color: white;"><i class="fas fa-times"></i> No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <small class="text-muted d-block">Ha donado antes</small>
                                            @if($pet->has_donated_before)
                                                <span class="badge" style="background: #93C01F; color: white;"><i class="fas fa-check"></i> Sí</span>
                                            @else
                                                <span class="badge" style="background: #6c757d; color: white;"><i class="fas fa-times"></i> No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Fechas importantes --}}
                                <div class="mt-4">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Fecha de registro</small>
                                                <strong style="color: #43883D;">{{ $pet->created_at->format('d/m/Y H:i') }}</strong>
                                            </div>
                                            @if($pet->approved_at)
                                            <div class="col-6">
                                                <small class="text-muted d-block">Fecha de aprobación</small>
                                                <strong style="color: #43883D;">{{ $pet->approved_at->format('d/m/Y H:i') }}</strong>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            </div>

            <div class="col-lg-4">
                <!-- Información del Tutor -->
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-user me-2"></i> Información del Tutor
                        </h5>
                        @if($pet->user)
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Nombre completo</small>
                                        <strong style="color: #43883D;">{{ $pet->user->name }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Email</small>
                                        <a href="mailto:{{ $pet->user->email }}" style="color: #43883D; text-decoration: none;">
                                            {{ $pet->user->email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Teléfono</small>
                                        @if($pet->user->phone)
                                            <a href="tel:{{ $pet->user->phone }}" style="color: #43883D; text-decoration: none;">
                                                {{ $pet->user->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">No disponible</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <small class="text-muted d-block">Documento</small>
                                        <strong style="color: #43883D;">{{ $pet->user->document_id ?? 'No disponible' }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Información del tutor no disponible</p>
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
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-stethoscope me-2"></i> Condiciones de Salud
                        </h5>
                        @foreach($pet->healthConditions as $condition)
                            <div class="mb-3 p-3 rounded" style="background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #F8DC0B;">
                                <h6 style="color: #43883D; margin-bottom: 8px;">{{ $condition->condition_type ?? 'Condición de Salud' }}</h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Estado</small>
                                    @if($condition->has_condition)
                                        <span class="badge" style="background: #C20E1A; color: white;"><i class="fas fa-exclamation-triangle"></i> Sí tiene esta condición</span>
                                    @else
                                        <span class="badge" style="background: #43883D; color: white;"><i class="fas fa-check"></i> No tiene esta condición</span>
                                    @endif
                                </div>
                                @if($condition->notes)
                                <div class="mb-2">
                                    <small class="text-muted d-block">Notas</small>
                                    <p class="mb-0" style="color: #43883D;">{{ $condition->notes }}</p>
                                </div>
                                @endif
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $condition->created_at ? $condition->created_at->format('d/m/Y H:i') : 'Fecha no disponible' }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="card border-0 mb-4" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-heartbeat me-2"></i> Condiciones de Salud
                        </h5>
                        <div class="text-center py-4">
                            <i class="fas fa-heartbeat fa-3x mb-3" style="color: #93C01F;"></i>
                            <h6 class="text-muted">Sin condiciones registradas</h6>
                            <p class="text-muted mb-0">Esta mascota no tiene condiciones de salud específicas registradas.</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Acciones -->
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        <h5 class="fw-medium mb-3" style="color: #43883D; border-bottom: 2px solid #43883D; padding-bottom: 8px;">
                            <i class="fas fa-cogs me-2"></i> Acciones
                        </h5>
                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.pets.edit', $pet->id) }}"
                               class="btn"
                               style="background: #F8DC0B; color: #43883D; border: none; border-radius: 8px; font-weight: 500; padding: 12px 20px;">
                                <i class="fas fa-edit me-2"></i> Editar Mascota
                            </a>

                            <form method="POST" action="{{ route('admin.pets.destroy', $pet->id) }}"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta mascota?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn w-100"
                                        style="background: #C20E1A; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px 20px;">
                                    <i class="fas fa-trash me-2"></i> Eliminar Mascota
                                </button>
                            </form>
                        </div>
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
        <div class="modal-content" style="border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: #43883D; color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" id="photoModalLabel">
                    <i class="fas fa-camera me-2"></i> Foto de {{ $pet->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $pet->photo_path) }}"
                         alt="Foto de {{ $pet->name }}"
                         class="img-fluid w-100"
                         style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e9ecef;">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ $pet->name }} - {{ ucfirst($pet->species) }}, {{ $pet->breed }}
                        </small>
                    </div>
                    <div>
                        <a href="{{ asset('storage/' . $pet->photo_path) }}" target="_blank"
                           class="btn btn-sm me-2"
                           style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 6px;">
                            <i class="fas fa-external-link-alt me-1"></i> Nueva pestaña
                        </a>
                        <button type="button" class="btn btn-sm"
                                style="background: #6c757d; color: white; border: none; border-radius: 6px;"
                                data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Estilos consistentes --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');

* {
    font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border-radius: 12px !important;
    border: none;
}

.btn {
    font-weight: 500;
    transition: all 0.2s ease;
}

.badge {
    border-radius: 6px;
    font-size: 0.8rem;
    padding: 6px 12px;
}
</style>

@endsection