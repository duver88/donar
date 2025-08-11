{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard Super Administrador</h2>
            <p class="text-muted">Panel de control y gestión del sistema</p>
        </div>
    </div>

    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['pending_veterinarians'] }}</h4>
                            <p class="mb-0">Veterinarios Pendientes</p>
                        </div>
                        <div>
                            <i class="fas fa-user-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-arrow-up"></i> Requieren aprobación
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['approved_veterinarians'] }}</h4>
                            <p class="mb-0">Veterinarios Aprobados</p>
                        </div>
                        <div>
                            <i class="fas fa-user-md fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-check"></i> Activos en el sistema
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_donors'] }}</h4>
                            <p class="mb-0">Donantes Aprobados</p>
                        </div>
                        <div>
                            <i class="fas fa-dog fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-heart"></i> Listos para donar
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['active_requests'] }}</h4>
                            <p class="mb-0">Solicitudes Activas</p>
                        </div>
                        <div>
                            <i class="fas fa-heartbeat fa-2x opacity-75"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="opacity-75">
                            <i class="fas fa-clock"></i> En proceso
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Veterinarios Pendientes --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-user-clock text-primary"></i> Veterinarios Pendientes de Aprobación</h5>
                </div>
                <div class="card-body">
                    @if($pendingVeterinarians->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Veterinario</th>
                                        <th>Tarjeta Profesional</th>
                                        <th>Clínica</th>
                                        <th>Ciudad</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingVeterinarians as $vet)
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $vet->name }}</strong><br>
                                                <small class="text-muted">{{ $vet->email }}</small><br>
                                                <small class="text-muted">{{ $vet->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $vet->veterinarian->professional_card }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $vet->veterinarian->clinic_name }}</strong><br>
                                                <small class="text-muted">{{ $vet->veterinarian->clinic_address }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $vet->veterinarian->city }}</td>
                                        <td>{{ $vet->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-success" 
                                                        onclick="approveVeterinarian({{ $vet->id }})"
                                                        title="Aprobar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" 
                                                        onclick="showRejectModal({{ $vet->id }}, '{{ $vet->name }}')"
                                                        title="Rechazar">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                            <h5 class="text-muted">No hay veterinarios pendientes</h5>
                            <p class="text-muted">Todas las solicitudes han sido procesadas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Solicitudes Recientes --}}
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-history text-warning"></i> Solicitudes Recientes</h5>
                </div>
                <div class="card-body">
                    @if($recentRequests->count() > 0)
                        @foreach($recentRequests as $request)
                        <div class="d-flex justify-content-between align-items-start border-bottom py-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $request->patient_name }}</h6>
                                <p class="mb-1 text-muted small">{{ $request->patient_breed }}</p>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-{{ $request->urgency_color }}">
                                        {{ ucfirst($request->urgency_level) }}
                                    </span>
                                    <small class="text-muted">{{ $request->veterinarian->name }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay solicitudes recientes</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.blood_requests') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fas fa-eye"></i> Ver Todas las Solicitudes
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Enlaces Rápidos --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-link text-info"></i> Enlaces Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.veterinarians') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-user-md"></i> Gestionar Veterinarios
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.pets') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-dog"></i> Gestionar Mascotas
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.blood_requests') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-heartbeat"></i> Ver Solicitudes
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('home') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-home"></i> Ver Sitio Público
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para rechazar veterinario --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-times-circle text-danger"></i> Rechazar Veterinario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas rechazar a <strong id="vetName"></strong>?</p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Motivo del rechazo *</label>
                        <textarea class="form-control" name="rejection_reason" rows="3" 
                                  placeholder="Explica el motivo del rechazo..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function approveVeterinarian(id) {
    if (confirm('¿Aprobar este veterinario? Podrá acceder al sistema inmediatamente.')) {
        fetch(`/admin/veterinarios/${id}/aprobar`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al aprobar veterinario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        });
    }
}

function showRejectModal(id, name) {
    document.getElementById('vetName').textContent = name;
    document.getElementById('rejectForm').action = `/admin/veterinarios/${id}/rechazar`;
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection