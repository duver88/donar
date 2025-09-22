@extends('layouts.app')

@section('title', 'Detalles de ' . $veterinarian->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <!-- Información Principal -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-md"></i> Información del Veterinario
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($veterinarian->veterinarian?->professional_card_photo)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $veterinarian->veterinarian->professional_card_photo) }}"
                                         alt="Tarjeta profesional de {{ $veterinarian->name }}"
                                         class="img-fluid rounded shadow-sm cursor-pointer"
                                         style="max-height: 300px; width: 100%; object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#cardPhotoModal"
                                         title="Click para ver en tamaño completo">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-dark bg-opacity-75">
                                            <i class="fas fa-expand"></i> Ver grande
                                        </span>
                                    </div>
                                </div>
                                <p class="text-muted mt-2">
                                    <i class="fas fa-id-card"></i> Tarjeta Profesional
                                </p>
                            @else
                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center mb-3"
                                     style="height: 200px;">
                                    <i class="fas fa-id-card fa-4x text-white"></i>
                                </div>
                                <p class="text-muted text-center">
                                    <i class="fas fa-camera-slash"></i> Sin foto de tarjeta profesional
                                </p>
                            @endif

                            <div class="text-center">
                                @switch($veterinarian->status)
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
                            <h3>{{ $veterinarian->name }}</h3>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Email:</strong> {{ $veterinarian->email }}
                                </div>
                                <div class="col-6">
                                    <strong>Teléfono:</strong> {{ $veterinarian->phone }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Documento:</strong> {{ $veterinarian->document_id ?? 'No registrado' }}
                                </div>
                                <div class="col-6">
                                    <strong>Fecha de Registro:</strong> {{ $veterinarian->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>

                            @if($veterinarian->approved_at)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        <strong>Aprobado el:</strong> {{ $veterinarian->approved_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Profesional -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-id-card"></i> Información Profesional
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Tarjeta Profesional:</strong>
                            <span class="badge bg-info ms-2">{{ $veterinarian->veterinarian?->professional_card ?? 'No registrada' }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Especialidad:</strong>
                            {{ $veterinarian->veterinarian?->specialty ?? 'No especificada' }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <strong>Estado Profesional:</strong>
                            @switch($veterinarian->status)
                                @case('pending')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock"></i> En revisión
                                    </span>
                                    @break
                                @case('approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Verificado y aprobado
                                    </span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> Rechazado
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de la Clínica -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-hospital"></i> Información de la Clínica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <strong>Nombre de la Clínica:</strong>
                            <h6 class="text-primary">{{ $veterinarian->veterinarian?->clinic_name ?? 'No registrada' }}</h6>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>Ciudad:</strong>
                            <span class="badge bg-secondary">{{ $veterinarian->veterinarian?->city ?? 'No especificada' }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <strong>Dirección:</strong>
                            <p class="mb-0">{{ $veterinarian->veterinarian?->clinic_address ?? 'No registrada' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Solicitudes de Sangre (si las tiene) -->
            @if($veterinarian->veterinarian && $veterinarian->veterinarian->bloodRequests && $veterinarian->veterinarian->bloodRequests->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat"></i> Solicitudes de Sangre Realizadas
                        <span class="badge bg-dark ms-2">{{ $veterinarian->veterinarian->bloodRequests->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Tipo de Sangre</th>
                                    <th>Urgencia</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($veterinarian->veterinarian->bloodRequests->take(10) as $request)
                                <tr>
                                    <td>
                                        <strong>{{ $request->patient_name }}</strong><br>
                                        <small class="text-muted">{{ $request->patient_breed }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $request->blood_type ?? 'No especificado' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $request->urgency_level === 'alta' ? 'danger' : ($request->urgency_level === 'media' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($request->urgency_level) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $request->status === 'active' ? 'success' : ($request->status === 'completed' ? 'primary' : 'secondary') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.blood_requests.show', $request->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($veterinarian->veterinarian->bloodRequests->count() > 10)
                    <div class="text-center">
                        <a href="{{ route('admin.blood_requests') }}?veterinarian={{ $veterinarian->id }}" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> Ver todas las solicitudes ({{ $veterinarian->veterinarian->bloodRequests->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-heartbeat"></i> Solicitudes de Sangre
                    </h5>
                </div>
                <div class="card-body text-center py-4">
                    <i class="fas fa-heartbeat fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Sin solicitudes de sangre registradas</h6>
                    <p class="text-muted mb-0">Este veterinario aún no ha realizado solicitudes de sangre en el sistema.</p>
                </div>
            </div>
            @endif

            <!-- Acciones -->
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs"></i> Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.veterinarians.edit', $veterinarian->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Información
                        </a>

                        @if($veterinarian->status === 'pending')
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('admin.approve_veterinarian', $veterinarian->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-check"></i> Aprobar Veterinario
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times"></i> Rechazar Veterinario
                                </button>
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('admin.veterinarians.destroy', $veterinarian->id) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este veterinario? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Eliminar Veterinario
                            </button>
                        </form>

                        <a href="{{ route('admin.veterinarians') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($veterinarian->veterinarian?->professional_card_photo)
<!-- Modal para mostrar la foto de la tarjeta profesional en grande -->
<div class="modal fade" id="cardPhotoModal" tabindex="-1" aria-labelledby="cardPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardPhotoModalLabel">
                    <i class="fas fa-id-card"></i> Tarjeta Profesional de {{ $veterinarian->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $veterinarian->veterinarian->professional_card_photo) }}"
                         alt="Tarjeta profesional de {{ $veterinarian->name }}"
                         class="img-fluid w-100"
                         style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Tarjeta Profesional: {{ $veterinarian->veterinarian->professional_card }}
                        </small>
                    </div>
                    <div>
                        <a href="{{ asset('storage/' . $veterinarian->veterinarian->professional_card_photo) }}" target="_blank" class="btn btn-sm btn-outline-primary">
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

@if($veterinarian->status === 'pending')
<!-- Modal para rechazar veterinario -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-times text-danger"></i> Rechazar Veterinario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form action="{{ route('admin.reject_veterinarian', $veterinarian->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Atención:</strong> Vas a rechazar la solicitud de {{ $veterinarian->name }}.
                    </div>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Motivo del rechazo *</label>
                        <textarea class="form-control" name="rejection_reason" rows="4" required
                                  placeholder="Explica el motivo por el cual se rechaza la solicitud del veterinario..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Rechazar Veterinario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection