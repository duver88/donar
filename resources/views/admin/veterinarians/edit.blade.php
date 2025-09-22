@extends('layouts.app')

@section('title', 'Editar Veterinario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Editar Veterinario: {{ $veterinarian->name }}
                    </h4>
                    <small>Modificar los datos del veterinario registrado</small>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('admin.veterinarians.update', $veterinarian->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Datos Personales --}}
                        <div class="mb-4">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="fas fa-user"></i> Datos Personales
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $veterinarian->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico *</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $veterinarian->email) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone', $veterinarian->phone) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="document_id" class="form-label">Número de Documento *</label>
                                <input type="text" class="form-control" name="document_id" value="{{ old('document_id', $veterinarian->document_id) }}" required>
                            </div>
                        </div>

                        {{-- Datos Profesionales --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="fas fa-id-card"></i> Datos Profesionales
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="professional_card" class="form-label">Tarjeta Profesional *</label>
                                <input type="text" class="form-control" name="professional_card" value="{{ old('professional_card', $veterinarian->veterinarian?->professional_card) }}"
                                       placeholder="Ej: VET-001-2024" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialty" class="form-label">Especialidad</label>
                                <input type="text" class="form-control" name="specialty" value="{{ old('specialty', $veterinarian->veterinarian?->specialty) }}"
                                       placeholder="Ej: Medicina Interna, Cirugía, etc.">
                            </div>
                        </div>

                        {{-- Foto de Tarjeta Profesional --}}
                        <div class="mb-3">
                            <label for="professional_card_photo" class="form-label">Foto de la Tarjeta Profesional</label>

                            @if($veterinarian->veterinarian?->professional_card_photo)
                            <div class="mb-3">
                                <label class="form-label">Foto actual:</label>
                                <div class="text-center mb-3">
                                    <img src="{{ asset('storage/' . $veterinarian->veterinarian->professional_card_photo) }}"
                                         alt="Tarjeta profesional de {{ $veterinarian->name }}"
                                         class="img-fluid rounded shadow"
                                         style="max-height: 200px;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#cardPhotoModal"
                                         style="cursor: pointer;"
                                         title="Click para ver en tamaño completo">
                                </div>
                            </div>
                            @endif

                            <input type="file" class="form-control" name="professional_card_photo"
                                   accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">
                                <i class="fas fa-info-circle text-info"></i>
                                {{ $veterinarian->veterinarian?->professional_card_photo ? 'Cambiar foto de la tarjeta profesional' : 'Sube una foto clara de la tarjeta profesional' }}.
                                Formatos permitidos: JPG, PNG, PDF. Máximo 5MB.
                                {{ $veterinarian->veterinarian?->professional_card_photo ? ' (opcional - deja vacío para mantener la foto actual)' : '' }}
                            </div>

                            {{-- Vista previa del archivo --}}
                            <div id="photo-preview" class="mt-2" style="display: none;"></div>
                        </div>

                        {{-- Datos de la Clínica --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="fas fa-hospital"></i> Datos de la Clínica
                            </h5>
                        </div>

                        <div class="mb-3">
                            <label for="clinic_name" class="form-label">Nombre de la Clínica *</label>
                            <input type="text" class="form-control" name="clinic_name" value="{{ old('clinic_name', $veterinarian->veterinarian?->clinic_name) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="clinic_address" class="form-label">Dirección de la Clínica *</label>
                                <input type="text" class="form-control" name="clinic_address" value="{{ old('clinic_address', $veterinarian->veterinarian?->clinic_address) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Ciudad *</label>
                                <select class="form-select" name="city" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="Bogotá" {{ old('city', $veterinarian->veterinarian?->city) == 'Bogotá' ? 'selected' : '' }}>Bogotá</option>
                                    <option value="Medellín" {{ old('city', $veterinarian->veterinarian?->city) == 'Medellín' ? 'selected' : '' }}>Medellín</option>
                                    <option value="Cali" {{ old('city', $veterinarian->veterinarian?->city) == 'Cali' ? 'selected' : '' }}>Cali</option>
                                    <option value="Barranquilla" {{ old('city', $veterinarian->veterinarian?->city) == 'Barranquilla' ? 'selected' : '' }}>Barranquilla</option>
                                    <option value="Cartagena" {{ old('city', $veterinarian->veterinarian?->city) == 'Cartagena' ? 'selected' : '' }}>Cartagena</option>
                                    <option value="Bucaramanga" {{ old('city', $veterinarian->veterinarian?->city) == 'Bucaramanga' ? 'selected' : '' }}>Bucaramanga</option>
                                    <option value="Pereira" {{ old('city', $veterinarian->veterinarian?->city) == 'Pereira' ? 'selected' : '' }}>Pereira</option>
                                    <option value="Manizales" {{ old('city', $veterinarian->veterinarian?->city) == 'Manizales' ? 'selected' : '' }}>Manizales</option>
                                    <option value="Otra" {{ old('city', $veterinarian->veterinarian?->city) == 'Otra' ? 'selected' : '' }}>Otra</option>
                                </select>
                            </div>
                        </div>

                        {{-- Estado del Veterinario --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-check-circle"></i> Estado del Veterinario
                            </h5>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Estado *</label>
                            <select class="form-select" name="status" required>
                                <option value="">-Seleccione-</option>
                                <option value="pending" {{ old('status', $veterinarian->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="approved" {{ old('status', $veterinarian->status) === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                <option value="rejected" {{ old('status', $veterinarian->status) === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                        </div>

                        {{-- Información adicional --}}
                        @if($veterinarian->approved_at)
                        <div class="alert alert-success mt-4">
                            <i class="fas fa-check-circle"></i>
                            <strong>Información:</strong> Este veterinario fue aprobado el {{ $veterinarian->approved_at->format('d/m/Y H:i') }}
                        </div>
                        @endif

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Actualizar Información del Veterinario
                            </button>
                            <a href="{{ route('admin.veterinarians.show', $veterinarian->id) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye"></i> Ver Detalles Completos
                            </a>
                            <a href="{{ route('admin.veterinarians') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Listado de Veterinarios
                            </a>
                        </div>
                    </form>
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

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.querySelector('[name="professional_card_photo"]');
    const previewContainer = document.getElementById('photo-preview');

    if (photoInput && previewContainer) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tamaño de archivo (5MB = 5 * 1024 * 1024 bytes)
                if (file.size > 5 * 1024 * 1024) {
                    alert('El archivo es muy grande. Máximo 5MB permitido.');
                    this.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type.includes('image')) {
                        previewContainer.innerHTML = `
                            <div class="border rounded p-3 bg-light">
                                <small class="text-muted d-block mb-2"><i class="fas fa-eye"></i> Vista previa:</small>
                                <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 200px; max-width: 100%;">
                                <div class="mt-2">
                                    <small class="text-success"><i class="fas fa-check"></i> ${file.name}</small>
                                    <br><small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                                </div>
                            </div>
                        `;
                    } else if (file.type.includes('pdf')) {
                        previewContainer.innerHTML = `
                            <div class="border rounded p-3 bg-light">
                                <small class="text-muted d-block mb-2"><i class="fas fa-file"></i> Archivo seleccionado:</small>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                                    <div>
                                        <strong>${file.name}</strong><br>
                                        <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    }
});
</script>
@endsection