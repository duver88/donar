@extends('layouts.app')

@section('title', 'Solicitud #' . $request->id)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-tint"></i>
                        Solicitud de Sangre #{{ $request->id }} - {{ $request->patient_name }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-paw"></i> Información del Paciente
                            </h5>
                            <div class="mb-2">
                                <strong>Nombre:</strong> {{ $request->patient_name }}
                            </div>
                            <div class="mb-2">
                                <strong>Especie:</strong> {{ ucfirst($request->patient_species ?? 'No especificado') }}
                            </div>
                            <div class="mb-2">
                                <strong>Raza:</strong> {{ $request->patient_breed ?? 'No especificado' }}
                            </div>
                            <div class="mb-2">
                                <strong>Edad:</strong> {{ $request->patient_age ?? 'No especificado' }}
                            </div>
                            <div class="mb-2">
                                <strong>Peso:</strong> {{ $request->patient_weight ?? 'No especificado' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-tint"></i> Detalles de la Solicitud
                            </h5>
                            <div class="mb-2">
                                <strong>Tipo de Sangre:</strong>
                                <span class="badge bg-dark fs-6">{{ $request->blood_type }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Cantidad Necesaria:</strong> {{ $request->quantity_needed ?? 'No especificado' }}
                            </div>
                            <div class="mb-2">
                                <strong>Urgencia:</strong>
                                @switch($request->urgency_level)
                                    @case('critica')
                                        <span class="badge bg-danger fs-6">
                                            <i class="fas fa-exclamation-triangle"></i> Crítica
                                        </span>
                                        @break
                                    @case('alta')
                                        <span class="badge bg-warning fs-6">
                                            <i class="fas fa-exclamation"></i> Alta
                                        </span>
                                        @break
                                    @case('media')
                                        <span class="badge bg-info fs-6">
                                            <i class="fas fa-info"></i> Media
                                        </span>
                                        @break
                                    @case('baja')
                                        <span class="badge bg-secondary fs-6">
                                            <i class="fas fa-minus"></i> Baja
                                        </span>
                                        @break
                                @endswitch
                            </div>
                            <div class="mb-2">
                                <strong>Estado:</strong>
                                @switch($request->status)
                                    @case('active')
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-heartbeat"></i> Activa
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-primary fs-6">
                                            <i class="fas fa-check"></i> Completada
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-secondary fs-6">
                                            <i class="fas fa-times"></i> Cancelada
                                        </span>
                                        @break
                                    @case('expired')
                                        <span class="badge bg-danger fs-6">
                                            <i class="fas fa-clock"></i> Expirada
                                        </span>
                                        @break
                                @endswitch
                            </div>
                            <div class="mb-2">
                                <strong>Fecha de Creación:</strong> {{ $request->created_at->format('d/m/Y H:i') }}
                            </div>
                            @if($request->completed_at)
                            <div class="mb-2">
                                <strong>Fecha de Completado:</strong> {{ $request->completed_at->format('d/m/Y H:i') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($request->medical_reason)
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-notes-medical"></i> Razón Médica
                        </h5>
                        <div class="bg-light p-3 rounded">
                            {{ $request->medical_reason }}
                        </div>
                    </div>
                    @endif

                    @if($request->additional_notes)
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-sticky-note"></i> Notas Adicionales
                        </h5>
                        <div class="bg-light p-3 rounded">
                            {{ $request->additional_notes }}
                        </div>
                    </div>
                    @endif

                    @if($request->admin_notes)
                    <div class="mb-4">
                        <h5 class="text-warning mb-3">
                            <i class="fas fa-user-shield"></i> Notas del Administrador
                        </h5>
                        <div class="bg-warning bg-opacity-10 p-3 rounded border border-warning">
                            {{ $request->admin_notes }}
                        </div>
                    </div>
                    @endif

                    <!-- Respuestas de donación -->
                    @if($request->donationResponses->count() > 0)
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-reply"></i> Respuestas de Donantes ({{ $request->donationResponses->count() }})
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Mascota</th>
                                        <th>Tutor</th>
                                        <th>Respuesta</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($request->donationResponses as $response)
                                    <tr>
                                        <td>
                                            <strong>{{ $response->pet->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $response->pet->breed ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $response->pet->user->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $response->pet->user->email ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if($response->response === 'accepted')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Aceptada
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Rechazada
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $response->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @switch($response->status)
                                                @case('pending')
                                                    <span class="badge bg-warning">Pendiente</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success">Completada</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-secondary">Cancelada</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Información del Veterinario -->
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md"></i> Veterinario Responsable
                    </h5>
                </div>
                <div class="card-body">
                    @if($request->veterinarian && $request->veterinarian->user)
                        <div class="mb-2">
                            <strong>Nombre:</strong><br>
                            {{ $request->veterinarian->user->name }}
                        </div>
                        <div class="mb-2">
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $request->veterinarian->user->email }}">
                                {{ $request->veterinarian->user->email }}
                            </a>
                        </div>
                        <div class="mb-2">
                            <strong>Teléfono:</strong><br>
                            @if($request->veterinarian->user->phone)
                                <a href="tel:{{ $request->veterinarian->user->phone }}">
                                    {{ $request->veterinarian->user->phone }}
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </div>
                        <div class="mb-2">
                            <strong>Licencia:</strong><br>
                            {{ $request->veterinarian->license_number ?? 'No disponible' }}
                        </div>
                        <div class="mb-2">
                            <strong>Clínica:</strong><br>
                            {{ $request->veterinarian->clinic_name ?? 'No disponible' }}
                        </div>
                        @if($request->veterinarian->clinic_address)
                        <div class="mb-2">
                            <strong>Dirección:</strong><br>
                            <small class="text-muted">{{ $request->veterinarian->clinic_address }}</small>
                        </div>
                        @endif
                    @else
                        <div class="text-muted">
                            <i class="fas fa-exclamation-triangle"></i>
                            Información del veterinario no disponible
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones de Estado -->
            @if($request->status === 'active')
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs"></i> Cambiar Estado
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.blood_requests.update_status', $request->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label">Nuevo Estado *</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="">-Seleccione-</option>
                                <option value="completed">Completada</option>
                                <option value="cancelled">Cancelada</option>
                                <option value="expired">Expirada</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Notas del Administrador</label>
                            <textarea class="form-control" name="admin_notes" id="admin_notes" rows="4"
                                      placeholder="Motivo del cambio de estado..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Actualizar Estado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Acciones Generales -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tools"></i> Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.blood_requests') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>

                        @if($request->veterinarian && $request->veterinarian->user)
                        <a href="mailto:{{ $request->veterinarian->user->email }}" class="btn btn-outline-primary">
                            <i class="fas fa-envelope"></i> Contactar Veterinario
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection