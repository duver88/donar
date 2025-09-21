{{-- resources/views/veterinarians/register.blade.php --}}
@extends('layouts.app')

@section('title', 'Registro de Veterinario')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-user-md"></i> Registro de Veterinario</h4>
                    <small>Únete a nuestra red de veterinarios colaboradores</small>
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

                    {{-- IMPORTANTE: Agregar enctype="multipart/form-data" --}}
                    <form action="{{ route('veterinarian.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Datos Personales --}}
                        <div class="mb-4">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="fas fa-user"></i> Datos Personales
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico *</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="document_id" class="form-label">Número de Documento *</label>
                                <input type="text" class="form-control" name="document_id" value="{{ old('document_id') }}" required>
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
                                <input type="text" class="form-control" name="professional_card" value="{{ old('professional_card') }}" 
                                       placeholder="Ej: VET-001-2024" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialty" class="form-label">Especialidad</label>
                                <input type="text" class="form-control" name="specialty" value="{{ old('specialty') }}" 
                                       placeholder="Ej: Medicina Interna, Cirugía, etc.">
                            </div>
                        </div>

                        {{-- NUEVO CAMPO: Foto de Tarjeta Profesional --}}
                        <div class="mb-3">
                            <label for="professional_card_photo" class="form-label">Foto de la Tarjeta Profesional *</label>
                            <input type="file" class="form-control" name="professional_card_photo" 
                                   accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="form-text">
                                <i class="fas fa-info-circle text-info"></i>
                                Sube una foto clara de tu tarjeta profesional veterinaria. 
                                Formatos permitidos: JPG, PNG, PDF. Máximo 5MB.
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <strong>Importante:</strong> Esta foto será revisada por el administrador para verificar tu identidad profesional.
                                </small>
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
                            <input type="text" class="form-control" name="clinic_name" value="{{ old('clinic_name') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="clinic_address" class="form-label">Dirección de la Clínica *</label>
                                <input type="text" class="form-control" name="clinic_address" value="{{ old('clinic_address') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Ciudad *</label>
                                <select class="form-select" name="city" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="Bogotá" {{ old('city') == 'Bogotá' ? 'selected' : '' }}>Bogotá</option>
                                    <option value="Medellín" {{ old('city') == 'Medellín' ? 'selected' : '' }}>Medellín</option>
                                    <option value="Cali" {{ old('city') == 'Cali' ? 'selected' : '' }}>Cali</option>
                                    <option value="Barranquilla" {{ old('city') == 'Barranquilla' ? 'selected' : '' }}>Barranquilla</option>
                                    <option value="Cartagena" {{ old('city') == 'Cartagena' ? 'selected' : '' }}>Cartagena</option>
                                    <option value="Bucaramanga" {{ old('city') == 'Bucaramanga' ? 'selected' : '' }}>Bucaramanga</option>
                                    <option value="Pereira" {{ old('city') == 'Pereira' ? 'selected' : '' }}>Pereira</option>
                                    <option value="Manizales" {{ old('city') == 'Manizales' ? 'selected' : '' }}>Manizales</option>
                                    <option value="Otra" {{ old('city') == 'Otra' ? 'selected' : '' }}>Otra</option>
                                </select>
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="fas fa-lock"></i> Contraseña de Acceso
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" class="form-control" name="password" required>
                                <div class="form-text">Mínimo 8 caracteres</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Proceso de Aprobación:</strong> Tu solicitud será revisada por nuestro equipo administrativo. 
                            Recibirás un email de confirmación una vez que tu cuenta sea aprobada. Este proceso puede tomar entre 24-48 horas.
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus"></i> Registrarme como Veterinario
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Inicio
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Inicia sesión aquí
                        </a>
                    </p>
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