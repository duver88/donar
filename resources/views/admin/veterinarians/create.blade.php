@extends('layouts.app')

@section('title', 'Crear Veterinario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #0369a1 100%); border-radius: 0.5rem 0.5rem 0 0;">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-user-md me-2" style="color: #fbbf24;"></i> Crear Nuevo Veterinario
                    </h4>
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

                    <form action="{{ route('admin.veterinarians.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Datos Personales --}}
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2" style="color: #1e3a8a;">
                                <i class="fas fa-user me-2" style="color: #fbbf24;"></i> Información Personal
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
                            <h5 class="fw-bold border-bottom pb-2" style="color: #1e3a8a;">
                                <i class="fas fa-stethoscope me-2" style="color: #fbbf24;"></i> Información Profesional
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="professional_card" class="form-label">Número de Tarjeta Profesional *</label>
                                <input type="text" class="form-control" name="professional_card" id="professional_card"
                                       value="{{ old('professional_card') }}" required placeholder="Ej: 12345">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialty" class="form-label">Especialidad</label>
                                <input type="text" class="form-control" name="specialty" id="specialty"
                                       value="{{ old('specialty') }}" placeholder="Ej: Cirugía, Cardiología, etc.">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="years_experience" class="form-label">Años de Experiencia *</label>
                                <input type="number" class="form-control" name="years_experience" id="years_experience"
                                       value="{{ old('years_experience') }}" min="0" max="50" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="professional_card_photo" class="form-label">Foto de Tarjeta Profesional</label>
                                <input type="file" class="form-control" name="professional_card_photo" id="professional_card_photo"
                                       accept=".jpg,.jpeg,.png,.pdf">
                                <div class="form-text">Formato: JPG, PNG o PDF. Máximo 2MB</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="clinic_name" class="form-label">Nombre de la Clínica *</label>
                            <input type="text" class="form-control" name="clinic_name" id="clinic_name"
                                   value="{{ old('clinic_name') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="clinic_address" class="form-label">Dirección de la Clínica *</label>
                                <textarea class="form-control" name="clinic_address" id="clinic_address" rows="3" required>{{ old('clinic_address') }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">Ciudad *</label>
                                <input type="text" class="form-control" name="city" id="city"
                                       value="{{ old('city', 'Bucaramanga') }}" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-lg fw-bold text-white" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); border: none; border-radius: 0.75rem; padding: 0.75rem 2rem; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(5, 150, 105, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(5, 150, 105, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(5, 150, 105, 0.3)'">
                                <i class="fas fa-save me-2"></i> Crear Veterinario
                            </button>
                            <a href="{{ route('admin.veterinarians') }}" class="btn fw-semibold" style="color: #6b7280; border: 2px solid #6b7280; border-radius: 0.75rem; padding: 0.75rem 2rem; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#6b7280'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280'">
                                <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection