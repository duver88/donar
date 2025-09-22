{{-- resources/views/admin/veterinarians/review.blade.php --}}
@extends('layouts.app')

@section('title', 'Revisar Solicitud de Veterinario')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-user-md text-primary"></i> Revisar Solicitud de Veterinario</h2>
                    <p class="text-muted mb-0">Solicitud pendiente de aprobación</p>
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Información del Veterinario --}}
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-user text-primary"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre Completo:</strong><br>{{ $veterinarian->name }}</p>
                            <p><strong>Correo Electrónico:</strong><br>{{ $veterinarian->email }}</p>
                            <p><strong>Teléfono:</strong><br>{{ $veterinarian->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Documento de Identidad:</strong><br>{{ $veterinarian->document_id }}</p>
                            <p><strong>Fecha de Registro:</strong><br>{{ $veterinarian->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Estado Actual:</strong><br>
                                <span class="badge bg-warning fs-6">{{ ucfirst($veterinarian->status) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-id-card text-success"></i> Información Profesional</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tarjeta Profesional:</strong><br>
                                <span class="badge bg-info fs-6">{{ $veterinarian->veterinarian->professional_card }}</span>
                            </p>
                            <p><strong>Especialidad:</strong><br>
                                {{ $veterinarian->veterinarian->specialty ?: 'No especificada' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if($veterinarian->veterinarian->professional_card_photo)
                                <p><strong>Foto Tarjeta Profesional:</strong></p>
                                <div class="border rounded p-2 bg-light">
                                    @if(str_contains($veterinarian->veterinarian->professional_card_photo, '.pdf'))
                                        <div class="text-center">
                                            <i class="fas fa-file-pdf text-danger fa-3x mb-2"></i>
                                            <br>
                                            <a href="{{ Storage::url($veterinarian->veterinarian->professional_card_photo) }}" 
                                               target="_blank" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-download"></i> Ver PDF
                                            </a>
                                        </div>
                                    @else
                                        <img src="{{ Storage::url($veterinarian->veterinarian->professional_card_photo) }}" 
                                             alt="Tarjeta Profesional" 
                                             class="img-fluid rounded"
                                             style="max-height: 200px; cursor: pointer;"
                                             onclick="openImageModal(this.src)">
                                        <div class="text-center mt-2">
                                            <a href="{{ Storage::url($veterinarian->veterinarian->professional_card_photo) }}" 
                                               target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-expand"></i> Ver en tamaño completo
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    No se subió foto de la tarjeta profesional
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-hospital text-info"></i> Información de la Clínica</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre de la Clínica:</strong><br>{{ $veterinarian->veterinarian->clinic_name }}</p>
                            <p><strong>Ciudad:</strong><br>{{ $veterinarian->veterinarian->city }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dirección:</strong><br>{{ $veterinarian->veterinarian->clinic_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel de Acciones --}}
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-cogs"></i> Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success btn-lg" onclick="approveVeterinarian()">
                            <i class="fas fa-check"></i> Aprobar Solicitud
                        </button>
                        
                        <button type="button" class="btn btn-danger btn-lg" onclick="showRejectModal()">
                            <i class="fas fa-times"></i> Rechazar Solicitud
                        </button>
                    </div>
                    
                    <hr>
                    
                    <h6><i class="fas fa-info-circle text-info"></i> Información</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i> 
                            Verifica que la tarjeta profesional sea válida
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i> 
                            Confirma que los datos sean coherentes
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success"></i> 
                            El veterinario recibirá un email automático
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para imagen --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarjeta Profesional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Tarjeta Profesional" class="img-fluid">
            </div>
        </div>
    </div>
</div>

{{-- Modal para rechazar --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-times-circle text-danger"></i> Rechazar Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.reject_veterinarian', $veterinarian->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas rechazar la solicitud de <strong>{{ $veterinarian->name }}</strong>?</p>
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
function approveVeterinarian() {
    if (confirm('¿Aprobar la solicitud de {{ $veterinarian->name }}? El veterinario recibirá un email de confirmación.')) {
        // Crear form para enviar POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.approve_veterinarian", $veterinarian->id) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function showRejectModal() {
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection