{{-- resources/views/blood-requests/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Solicitar Donación de Sangre')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border-radius: 0.5rem 0.5rem 0 0;">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-heartbeat me-2" style="color: #fbbf24;"></i> Solicitar Donación de Sangre</h4>
                    <small class="d-block mt-1" style="opacity: 0.9;">Solicita ayuda para tu paciente que necesita una transfusión</small>
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

                    <form action="{{ route('veterinarian.blood_request.store') }}" method="POST">
                        @csrf
                        
                        {{-- Datos del Paciente --}}
                        <div class="mb-4">
                            <h5 class="fw-bold border-bottom pb-2" style="color: #dc2626;">
                                <i class="fas fa-paw me-2" style="color: #fbbf24;"></i> Datos del Paciente
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
                            <h5 class="fw-bold border-bottom pb-2" style="color: #dc2626;">
                                <i class="fas fa-clock me-2" style="color: #fbbf24;"></i> Urgencia y Tiempo
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
                            <h5 class="fw-bold border-bottom pb-2" style="color: #dc2626;">
                                <i class="fas fa-stethoscope me-2" style="color: #fbbf24;"></i> Información Médica
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
                        <div class="alert" style="background: #eff6ff; border-left: 4px solid #1e3a8a; border-color: #bfdbfe;">
                            <i class="fas fa-info-circle me-2" style="color: #1e3a8a;"></i>
                            <strong style="color: #1e3a8a;">¿Cómo funciona?</strong>
                            <ul class="mb-0 mt-2">
                                <li>Al enviar esta solicitud, se notificará automáticamente a todos los donantes compatibles</li>
                                <li>Los tutores recibirán un email con los detalles del caso</li>
                                <li>Podrán responder si están interesados en ayudar</li>
                                <li>Recibirás las respuestas directamente en tu email registrado</li>
                            </ul>
                        </div>

                        {{-- Recordatorio de Urgencia --}}
                        <div class="alert" style="background: #fef3cd; border-left: 4px solid #f59e0b; border-color: #fde68a;">
                            <i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b;"></i>
                            <strong style="color: #f59e0b;">Recordatorio:</strong> Para casos críticos, también contacta directamente a las clínicas veterinarias cercanas 
                            que puedan tener donantes inmediatos disponibles.
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-lg fw-bold text-white" style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); border: none; border-radius: 0.75rem; padding: 0.75rem 2rem; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(220, 38, 38, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(220, 38, 38, 0.3)'">
                                <i class="fas fa-paper-plane me-2"></i> Enviar Solicitud de Donación
                            </button>
                            <a href="{{ route('veterinarian.dashboard') }}" class="btn fw-semibold" style="color: #6b7280; border: 2px solid #6b7280; border-radius: 0.75rem; padding: 0.75rem 2rem; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#6b7280'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6b7280'">
                                <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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