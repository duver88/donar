{{-- resources/views/pets/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Postular Mascota como Donante')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-dog"></i> Postular mi mascota como donante</h4>
                    <small>Completa este formulario para registrar a tu mascota como donante de sangre</small>
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

                    <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data" id="petForm">
                        @csrf
                        
                        {{-- Datos del Tutor --}}
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-user"></i> Datos del Tutor Responsable
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tutor_name" class="form-label">Nombre completo del tutor *</label>
                                <input type="text" class="form-control" name="tutor_name" value="{{ old('tutor_name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tutor_email" class="form-label">Correo Electrónico *</label>
                                <input type="email" class="form-control" name="tutor_email" value="{{ old('tutor_email') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tutor_document" class="form-label">Número de Documento de Identidad *</label>
                                <input type="text" class="form-control" name="tutor_document" value="{{ old('tutor_document') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tutor_phone" class="form-label">Teléfono de Contacto *</label>
                                <input type="tel" class="form-control" name="tutor_phone" value="{{ old('tutor_phone') }}" required>
                            </div>
                        </div>

                        {{-- Datos del Animal --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-dog"></i> Datos del Animal de Compañía
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pet_name" class="form-label">Nombre del Animal *</label>
                                <input type="text" class="form-control" name="pet_name" value="{{ old('pet_name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pet_breed" class="form-label">Raza *</label>
                                <input type="text" class="form-control" name="pet_breed" value="{{ old('pet_breed') }}" placeholder="Ej: Golden Retriever, Mestizo, etc." required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="pet_species" class="form-label">Especie *</label>
                                <select class="form-select" name="pet_species" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="perro" {{ old('pet_species') == 'perro' ? 'selected' : '' }}>Perro</option>
                                    <option value="gato" {{ old('pet_species') == 'gato' ? 'selected' : '' }}>Gato</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pet_age" class="form-label">Edad del Animal (en años) *</label>
                                <input type="number" class="form-control" name="pet_age" min="1" max="20" value="{{ old('pet_age') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pet_weight" class="form-label">Peso del Animal (kg) *</label>
                                <input type="number" class="form-control" name="pet_weight" step="0.1" min="1" value="{{ old('pet_weight') }}" required>
                                <div class="form-text">Mínimo 25kg para donación</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pet_health_status" class="form-label">Estado de Salud Actual del Animal *</label>
                            <select class="form-select" name="pet_health_status" required>
                                <option value="">-Seleccione-</option>
                                <option value="excelente" {{ old('pet_health_status') == 'excelente' ? 'selected' : '' }}>Excelente</option>
                                <option value="bueno" {{ old('pet_health_status') == 'bueno' ? 'selected' : '' }}>Bueno</option>
                                <option value="regular" {{ old('pet_health_status') == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="malo" {{ old('pet_health_status') == 'malo' ? 'selected' : '' }}>Malo</option>
                            </select>
                        </div>

                        {{-- Vacunas y Donaciones Previas --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-syringe"></i> Vacunas y Donaciones Previas
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿Está al día con las vacunas del animal? *</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vaccines_up_to_date" value="1" {{ old('vaccines_up_to_date') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vaccines_up_to_date" value="0" {{ old('vaccines_up_to_date') == '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿El animal ha donado sangre anteriormente? *</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="has_donated_before" value="0" {{ old('has_donated_before') == '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="has_donated_before" value="1" {{ old('has_donated_before') == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Condiciones de Salud --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-hospital"></i> Condiciones de Salud del Animal
                            </h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal tiene alguna enfermedad diagnosticada por un veterinario? *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="has_diagnosed_disease" value="1" {{ old('has_diagnosed_disease') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="has_diagnosed_disease" value="0" {{ old('has_diagnosed_disease') == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal está bajo tratamiento médico actualmente? *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="under_medical_treatment" value="1" {{ old('under_medical_treatment') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="under_medical_treatment" value="0" {{ old('under_medical_treatment') == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal ha tenido alguna cirugía reciente? *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recent_surgery" value="1" {{ old('recent_surgery') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recent_surgery" value="0" {{ old('recent_surgery') == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal ha sido diagnosticado con alguna de las siguientes enfermedades? (marca todas las que apliquen)</label>
                            <div class="row">
                                @php
                                $diseases = ['Leishmaniasis', 'Ehrlichiosis', 'Parvovirus', 'Anemia', 'Hepatitis', 'Cáncer', 'Otros'];
                                @endphp
                                @foreach($diseases as $disease)
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="diseases[]" value="{{ $disease }}" {{ in_array($disease, old('diseases', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $disease }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Foto del Animal --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-camera"></i> Foto del Animal
                            </h5>
                        </div>

                        <div class="mb-3">
                            <label for="pet_photo" class="form-label">Subir foto reciente del animal *</label>
                            <input type="file" class="form-control" name="pet_photo" accept=".jpg,.jpeg,.png" required>
                            <div class="form-text">PNG, JPG hasta 2MB</div>
                        </div>

                        <div class="alert alert-warning" id="eligibilityWarning" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Advertencia:</strong> <span id="warningMessage"></span>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Enviar Postulación
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Inicio
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
    const form = document.getElementById('petForm');
    const warningDiv = document.getElementById('eligibilityWarning');
    const warningMessage = document.getElementById('warningMessage');
    
    function checkEligibility() {
        const warnings = [];
        
        // Verificar peso
        const weight = parseFloat(document.querySelector('[name="pet_weight"]').value);
        if (weight && weight < 25) {
            warnings.push('peso insuficiente (mínimo 25kg)');
        }
        
        // Verificar vacunas
        const vaccines = document.querySelector('[name="vaccines_up_to_date"]:checked');
        if (vaccines && vaccines.value === '0') {
            warnings.push('vacunas no están al día');
        }
        
        // Verificar estado de salud
        const healthStatus = document.querySelector('[name="pet_health_status"]').value;
        if (healthStatus === 'malo') {
            warnings.push('estado de salud malo');
        }
        
        // Verificar condiciones médicas
        const hasDiagnosed = document.querySelector('[name="has_diagnosed_disease"]:checked');
        if (hasDiagnosed && hasDiagnosed.value === '1') {
            warnings.push('tiene enfermedad diagnosticada');
        }
        
        const underTreatment = document.querySelector('[name="under_medical_treatment"]:checked');
        if (underTreatment && underTreatment.value === '1') {
            warnings.push('está bajo tratamiento médico');
        }
        
        const recentSurgery = document.querySelector('[name="recent_surgery"]:checked');
        if (recentSurgery && recentSurgery.value === '1') {
            warnings.push('tuvo cirugía reciente');
        }
        
        // Verificar enfermedades
        const diseases = document.querySelectorAll('[name="diseases[]"]:checked');
        if (diseases.length > 0) {
            const diseaseList = Array.from(diseases).map(d => d.value).join(', ');
            warnings.push(`tiene las siguientes enfermedades: ${diseaseList}`);
        }
        
        if (warnings.length > 0) {
            warningMessage.textContent = `Tu mascota podría no ser apta para donar porque: ${warnings.join(', ')}`;
            warningDiv.style.display = 'block';
        } else {
            warningDiv.style.display = 'none';
        }
    }
    
    // Agregar event listeners a todos los campos relevantes
    form.addEventListener('change', checkEligibility);
    form.addEventListener('input', checkEligibility);
});
</script>
@endsection