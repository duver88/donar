{{-- resources/views/veterinarians/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Registro de Veterinario')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    {{-- Header --}}
                    <div class="text-center mb-5">
                        <h1 class="h3 fw-light mb-2" style="color: #43883D;">Registro de Veterinario</h1>
                        <p class="text-muted">Únete a nuestra red de profesionales colaboradores</p>
                    </div>

                    {{-- Formulario --}}
                    <div class="card border-0" style="border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger border-0" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                                    <h6 class="fw-medium mb-2">Errores encontrados:</h6>
                                    <ul class="mb-0 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('veterinarian.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Datos Personales --}}
                                <div class="mb-4">
                                    <h6 class="fw-medium mb-3" style="color: #43883D;">Datos Personales</h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Nombre Completo *</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Correo Electrónico *</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Teléfono *</label>
                                        <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Número de Documento *</label>
                                        <input type="text" class="form-control" name="document_id" value="{{ old('document_id') }}"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                </div>

                                {{-- Datos Profesionales --}}
                                <div class="mb-4 mt-5">
                                    <h6 class="fw-medium mb-3" style="color: #43883D;">Datos Profesionales</h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Tarjeta Profesional *</label>
                                        <input type="text" class="form-control" name="professional_card" value="{{ old('professional_card') }}"
                                               placeholder="Ej: VET-001-2024" style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Especialidad</label>
                                        <input type="text" class="form-control" name="specialty" value="{{ old('specialty') }}"
                                               placeholder="Ej: Medicina Interna" style="border-radius: 6px; border: 1px solid #ddd;">
                                    </div>
                                </div>

                                {{-- Foto de Tarjeta --}}
                                <div class="mb-4">
                                    <label class="form-label small text-muted">Foto de la Tarjeta Profesional *</label>
                                    <input type="file" class="form-control" name="professional_card_photo"
                                           accept=".jpg,.jpeg,.png,.pdf" style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    <div class="mt-2">
                                        <small class="text-muted">Formatos: JPG, PNG, PDF. Máximo 5MB.</small>
                                    </div>
                                    <div id="photo-preview" class="mt-2" style="display: none;"></div>
                                </div>

                                {{-- Datos de la Clínica --}}
                                <div class="mb-4 mt-5">
                                    <h6 class="fw-medium mb-3" style="color: #43883D;">Datos de la Clínica</h6>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small text-muted">Nombre de la Clínica *</label>
                                    <input type="text" class="form-control" name="clinic_name" value="{{ old('clinic_name') }}"
                                           style="border-radius: 6px; border: 1px solid #ddd;" required>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label small text-muted">Dirección de la Clínica *</label>
                                        <input type="text" class="form-control" name="clinic_address" value="{{ old('clinic_address') }}"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted">Ciudad *</label>
                                        <select class="form-select" name="city" style="border-radius: 6px; border: 1px solid #ddd;" required>
                                            <option value="">Seleccione</option>
                                            <option value="Bogotá" {{ old('city') == 'Bogotá' ? 'selected' : '' }}>Bogotá</option>
                                            <option value="Medellín" {{ old('city') == 'Medellín' ? 'selected' : '' }}>Medellín</option>
                                            <option value="Cali" {{ old('city') == 'Cali' ? 'selected' : '' }}>Cali</option>
                                            <option value="Barranquilla" {{ old('city') == 'Barranquilla' ? 'selected' : '' }}>Barranquilla</option>
                                            <option value="Bucaramanga" {{ old('city') == 'Bucaramanga' ? 'selected' : '' }}>Bucaramanga</option>
                                            <option value="Pereira" {{ old('city') == 'Pereira' ? 'selected' : '' }}>Pereira</option>
                                            <option value="Otra" {{ old('city') == 'Otra' ? 'selected' : '' }}>Otra</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Contraseña --}}
                                <div class="mb-4 mt-5">
                                    <h6 class="fw-medium mb-3" style="color: #43883D;">Contraseña de Acceso</h6>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Contraseña *</label>
                                        <input type="password" class="form-control" name="password"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                        <small class="text-muted">Mínimo 8 caracteres</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Confirmar Contraseña *</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                               style="border-radius: 6px; border: 1px solid #ddd;" required>
                                    </div>
                                </div>

                                <div class="mt-4 p-3 rounded" style="background: rgba(67, 136, 61, 0.05); border-left: 4px solid #43883D;">
                                    <h6 class="fw-medium mb-2" style="color: #43883D;">Proceso de Aprobación</h6>
                                    <p class="small text-muted mb-0">
                                        Tu solicitud será revisada en 24-48 horas. Recibirás un email de confirmación una vez aprobada.
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn w-100 mb-3" style="background: #43883D; color: white; border: none; border-radius: 6px; padding: 12px;">
                                        Registrarme como Veterinario
                                    </button>
                                    <div class="text-center">
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary" style="border-radius: 6px;">
                                            Volver al Inicio
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="text-center mt-4">
                        <p class="text-muted">
                            ¿Ya tienes cuenta?
                            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #43883D;">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.querySelector('[name="professional_card_photo"]');
    const previewContainer = document.getElementById('photo-preview');
    
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
});
</script>
@endsection