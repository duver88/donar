{{-- resources/views/blood-requests/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Solicitar Donación de Sangre')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header --}}
    <div class="py-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        <i class="fas fa-heartbeat me-2"></i>
                        Solicitar Donación de Sangre
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Solicita ayuda para tu paciente que necesita una transfusión
                    </p>
                </div>
                <div>
                    <a href="{{ route('veterinarian.dashboard') }}"
                       class="btn"
                       style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.9rem; padding: 12px 20px; font-weight: 500;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger" style="border-radius: 8px; border: none; background: rgba(194, 14, 26, 0.1);">
                                <h6 style="color: #C20E1A;"><i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: #C20E1A;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('veterinarian.blood_request.store') }}" method="POST">
                            @csrf

                            {{-- Datos del Paciente --}}
                            <div class="mb-4">
                                <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                    <i class="fas fa-paw me-2"></i> Datos del Paciente
                                </h5>
                            </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_name" class="form-label">Nombre del Paciente *</label>
                                <input type="text" class="form-control" name="patient_name" value="{{ old('patient_name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="patient_breed" class="form-label">Raza *</label>
                                <input type="text" class="form-control" name="patient_breed" value="{{ old('patient_breed') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="patient_weight" class="form-label">Peso del Paciente (kg) *</label>
                                <input type="number" class="form-control" name="patient_weight" step="0.1" min="1" value="{{ old('patient_weight') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="blood_type_needed" class="form-label">Tipo de Sangre Necesaria *</label>
                                <select class="form-select" name="blood_type_needed" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="DEA 1.1+" {{ old('blood_type_needed') == 'DEA 1.1+' ? 'selected' : '' }}>DEA 1.1+ (Donante universal)</option>
                                    <option value="DEA 1.1-" {{ old('blood_type_needed') == 'DEA 1.1-' ? 'selected' : '' }}>DEA 1.1-</option>
                                    <option value="Universal" {{ old('blood_type_needed') == 'Universal' ? 'selected' : '' }}>Universal (Cualquier tipo)</option>
                                </select>
                            </div>
                        </div>

                            {{-- Urgencia y Timing --}}
                            <div class="mb-4 mt-4">
                                <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                    <i class="fas fa-clock me-2"></i> Urgencia y Tiempo
                                </h5>
                            </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="urgency_level" class="form-label">Nivel de Urgencia *</label>
                                <select class="form-select" name="urgency_level" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="baja" {{ old('urgency_level') == 'baja' ? 'selected' : '' }}>
                                        Baja - Programada (1-2 semanas)
                                    </option>
                                    <option value="media" {{ old('urgency_level') == 'media' ? 'selected' : '' }}>
                                        Media - Esta semana
                                    </option>
                                    <option value="alta" {{ old('urgency_level') == 'alta' ? 'selected' : '' }}>
                                        Alta - En 24-48 horas
                                    </option>
                                    <option value="critica" {{ old('urgency_level') == 'critica' ? 'selected' : '' }}>
                                        Crítica - Emergencia inmediata
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="needed_by_date" class="form-label">Fecha y Hora Límite *</label>
                                <input type="datetime-local" class="form-control" name="needed_by_date" 
                                       min="{{ date('Y-m-d\TH:i') }}" value="{{ old('needed_by_date') }}" required>
                            </div>
                        </div>

                            {{-- Información Médica --}}
                            <div class="mb-4 mt-4">
                                <h5 class="fw-medium border-bottom pb-2 mb-3" style="color: #43883D; border-color: #e9ecef !important;">
                                    <i class="fas fa-stethoscope me-2"></i> Información Médica
                                </h5>
                            </div>

                        <div class="mb-3">
                            <label for="medical_reason" class="form-label">Razón Médica para la Transfusión *</label>
                            <textarea class="form-control" name="medical_reason" rows="4" 
                                      placeholder="Describe el diagnóstico, condición médica y por qué necesita la transfusión..." required>{{ old('medical_reason') }}</textarea>
                            <div class="form-text">Incluye diagnóstico, síntomas principales, tratamientos previos y urgencia del caso</div>
                        </div>

                        <div class="mb-3">
                            <label for="clinic_contact" class="form-label">Información de Contacto de la Clínica *</label>
                            <input type="text" class="form-control" name="clinic_contact" 
                                   placeholder="Teléfono de emergencia, dirección específica, contacto alternativo..." 
                                   value="{{ old('clinic_contact') }}" required>
                            <div class="form-text">Los tutores necesitarán esta información para coordinar la donación</div>
                        </div>

                            {{-- Información Importante --}}
                            <div class="alert" style="border-radius: 8px; border: none; background: rgba(67, 136, 61, 0.1);">
                                <i class="fas fa-info-circle me-2" style="color: #43883D;"></i>
                                <strong style="color: #43883D;">¿Cómo funciona?</strong>
                                <ul class="mb-0 mt-2" style="color: #43883D;">
                                    <li>Al enviar esta solicitud, se notificará automáticamente a todos los donantes compatibles</li>
                                    <li>Los tutores recibirán un email con los detalles del caso</li>
                                    <li>Podrán responder si están interesados en ayudar</li>
                                    <li>Recibirás las respuestas directamente en tu email registrado</li>
                                </ul>
                            </div>

                            {{-- Recordatorio de Urgencia --}}
                            <div class="alert" style="border-radius: 8px; border: none; background: rgba(248, 220, 11, 0.1);">
                                <i class="fas fa-exclamation-triangle me-2" style="color: #F8DC0B;"></i>
                                <strong style="color: #43883D;">Recordatorio:</strong> <span style="color: #43883D;">Para casos críticos, también contacta directamente a las clínicas veterinarias cercanas que puedan tener donantes inmediatos disponibles.</span>
                            </div>

                            <div class="d-grid gap-3 mt-4">
                                <button type="submit" class="btn btn-lg"
                                        style="background: #43883D; color: white; border: none; border-radius: 8px; font-weight: 500; padding: 12px 24px;">
                                    <i class="fas fa-paper-plane me-2"></i> Enviar Solicitud de Donación
                                </button>
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urgencySelect = document.querySelector('[name="urgency_level"]');
    const dateInput = document.querySelector('[name="needed_by_date"]');
    
    urgencySelect.addEventListener('change', function() {
        const now = new Date();
        let suggestedDate = new Date(now);
        
        switch(this.value) {
            case 'critica':
                // Añadir 6 horas para casos críticos
                suggestedDate.setHours(now.getHours() + 6);
                break;
            case 'alta':
                // Añadir 24 horas para casos de alta urgencia
                suggestedDate.setDate(now.getDate() + 1);
                break;
            case 'media':
                // Añadir 3 días para casos de urgencia media
                suggestedDate.setDate(now.getDate() + 3);
                break;
            case 'baja':
                // Añadir 1 semana para casos de baja urgencia
                suggestedDate.setDate(now.getDate() + 7);
                break;
        }
        
        if (this.value) {
            // Formatear fecha para input datetime-local
            const formattedDate = suggestedDate.toISOString().slice(0, 16);
            dateInput.value = formattedDate;
        }
    });
});
</script>
@endsection