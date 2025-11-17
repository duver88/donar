@extends('layouts.app')

@section('title', 'Crear Veterinario')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Crear Nuevo Veterinario
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Registrar un nuevo veterinario en el sistema
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.veterinarians') }}"
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

                    <form action="{{ route('admin.veterinarians.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Datos Personales --}}
                        <div class="mb-4">
                            <h5 class="fw-medium border-bottom pb-2" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-user me-2"></i> Información Personal
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo *</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono *</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                       value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="document_id" class="form-label">Número de Documento *</label>
                                <input type="text" class="form-control" name="document_id" id="document_id"
                                       value="{{ old('document_id') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado *</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="approved" {{ old('status') === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                        </div>

                        {{-- Datos Profesionales --}}
                        <div class="mb-4 mt-4">
                            <h5 class="fw-medium border-bottom pb-2" style="color: #43883D; border-color: #e9ecef !important;">
                                <i class="fas fa-stethoscope me-2"></i> Información Profesional
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="professional_card" class="form-label">Número de Tarjeta Profesional *</label>
                                <input type="text" class="form-control" name="professional_card" id="professional_card"
                                       value="{{ old('professional_card') }}" required placeholder="Ej: VET-001-2024">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialty" class="form-label">Especialidad</label>
                                <input type="text" class="form-control" name="specialty" id="specialty"
                                       value="{{ old('specialty') }}" placeholder="Ej: Medicina Interna">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="professional_card_photo" class="form-label">Foto de Tarjeta Profesional</label>
                            <input type="file" class="form-control" name="professional_card_photo" id="professional_card_photo"
                                   accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">Formato: JPG, PNG o PDF. Máximo 5MB</div>
                        </div>

                        <div class="mb-3">
                            <label for="clinic_name" class="form-label">Nombre de la Clínica *</label>
                            <input type="text" class="form-control" name="clinic_name" id="clinic_name"
                                   value="{{ old('clinic_name') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="clinic_address" class="form-label">Dirección de la Clínica *</label>
                                <input type="text" class="form-control" name="clinic_address" id="clinic_address"
                                       value="{{ old('clinic_address') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Ciudad *</label>
                                <select class="form-select" name="city" id="city" required>
                                    <option value="">Seleccione</option>
                                    <option value="Bogotá" {{ old('city') == 'Bogotá' ? 'selected' : '' }}>Bogotá</option>
                                    <option value="Medellín" {{ old('city') == 'Medellín' ? 'selected' : '' }}>Medellín</option>
                                    <option value="Cali" {{ old('city') == 'Cali' ? 'selected' : '' }}>Cali</option>
                                    <option value="Barranquilla" {{ old('city') == 'Barranquilla' ? 'selected' : '' }}>Barranquilla</option>
                                    <option value="Bucaramanga" {{ old('city', 'Bucaramanga') == 'Bucaramanga' ? 'selected' : '' }}>Bucaramanga</option>
                                    <option value="Pereira" {{ old('city') == 'Pereira' ? 'selected' : '' }}>Pereira</option>
                                    <option value="Otra" {{ old('city') == 'Otra' ? 'selected' : '' }}>Otra</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn flex-fill"
                                    style="background: #43883D; color: white; border: none; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500; transition: all 0.2s ease;"
                                    onmouseover="this.style.background='#285F19'"
                                    onmouseout="this.style.background='#43883D'">
                                <i class="fas fa-save me-2"></i> Crear Veterinario
                            </button>
                            <a href="{{ route('admin.veterinarians') }}" class="btn"
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