@extends('layouts.app')

@section('title', 'Editar ' . $pet->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Editar Mascota: {{ $pet->name }}
                    </h4>
                    <small>Modificar los datos de la mascota registrada</small>
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

                    <form action="{{ route('admin.pets.update', $pet->id) }}" method="POST" id="petForm">
                        @csrf
                        @method('PUT')

                        {{-- Información del Tutor (Editable por Admin) --}}
                        @if($pet->user)
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2" style="color: #43883D;">
                                <i class="fas fa-user"></i> Información del Tutor
                            </h5>
                            <div class="alert alert-info mt-2" style="font-size: 0.9rem;">
                                <i class="fas fa-info-circle"></i> Como administrador, puedes editar la información del tutor desde aquí.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Tutor *</label>
                                <input type="text" class="form-control" name="tutor_name" value="{{ old('tutor_name', $pet->user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email del Tutor *</label>
                                <input type="email" class="form-control" name="tutor_email" value="{{ old('tutor_email', $pet->user->email) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Documento del Tutor</label>
                                <input type="text" class="form-control" name="tutor_document_id" value="{{ old('tutor_document_id', $pet->user->document_id) }}" placeholder="Opcional">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono del Tutor *</label>
                                <input type="text" class="form-control" name="tutor_phone" value="{{ old('tutor_phone', $pet->user->phone) }}" required>
                            </div>
                        </div>
                        @endif

                        {{-- Datos del Animal --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-dog"></i> Datos del Animal de Compañía
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre del Animal *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $pet->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="breed" class="form-label">Raza *</label>
                                <input type="text" class="form-control" name="breed" id="breed" value="{{ old('breed', $pet->breed) }}" placeholder="Ej: Golden Retriever, Mestizo, etc." required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="species" class="form-label">Especie *</label>
                                <select class="form-select" name="species" id="species" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="perro" {{ old('species', $pet->species) == 'perro' ? 'selected' : '' }}>Perro</option>
                                    <option value="gato" {{ old('species', $pet->species) == 'gato' ? 'selected' : '' }}>Gato</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="age_years" class="form-label">Edad del Animal (en años) *</label>
                                <input type="number" class="form-control" name="age_years" id="age_years" min="1" max="20" value="{{ old('age_years', $pet->age_years ?? $pet->age) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="weight_kg" class="form-label">Peso del Animal (kg) *</label>
                                <input type="number" class="form-control" name="weight_kg" id="weight_kg" step="0.1" min="1" value="{{ old('weight_kg', $pet->weight_kg ?? $pet->weight) }}" required>
                                <div class="form-text">Mínimo 25kg para donación</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="health_status" class="form-label">Estado de Salud Actual del Animal *</label>
                            <select class="form-select" name="health_status" id="health_status" required>
                                <option value="">-Seleccione-</option>
                                <option value="excelente" {{ old('health_status', $pet->health_status) == 'excelente' ? 'selected' : '' }}>Excelente</option>
                                <option value="bueno" {{ old('health_status', $pet->health_status) == 'bueno' ? 'selected' : '' }}>Bueno</option>
                                <option value="regular" {{ old('health_status', $pet->health_status) == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="malo" {{ old('health_status', $pet->health_status) == 'malo' ? 'selected' : '' }}>Malo</option>
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
                                        <input class="form-check-input" type="radio" name="vaccines_up_to_date" value="1" {{ old('vaccines_up_to_date', $pet->vaccines_up_to_date ?? $pet->vaccination_status) == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vaccines_up_to_date" value="0" {{ old('vaccines_up_to_date', $pet->vaccines_up_to_date ?? $pet->vaccination_status) == '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">¿El animal ha donado sangre anteriormente? *</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="has_donated_before" value="0" {{ old('has_donated_before', $pet->has_donated_before) == '0' ? 'checked' : '' }} required>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="has_donated_before" value="1" {{ old('has_donated_before', $pet->has_donated_before) == '1' ? 'checked' : '' }} required>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Estado como Donante --}}
                        <div class="mb-4 mt-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-heart"></i> Estado como Donante
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="donor_status" class="form-label">Estado como Donante *</label>
                                <select class="form-select" name="donor_status" id="donor_status" required>
                                    <option value="">-Seleccione-</option>
                                    <option value="pending" {{ old('donor_status', $pet->donor_status ?? $pet->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="approved" {{ old('donor_status', $pet->donor_status ?? $pet->status) === 'approved' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rejected" {{ old('donor_status', $pet->donor_status ?? $pet->status) === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="blood_type" class="form-label">Tipo de Sangre</label>
                                <input type="text" class="form-control" name="blood_type" id="blood_type" value="{{ old('blood_type', $pet->blood_type) }}" placeholder="Ej: DEA 1.1+, A, B, etc.">
                                <div class="form-text">Opcional - Se puede determinar posteriormente</div>
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
                                    <input class="form-check-input" type="radio" name="has_diagnosed_disease" value="1" {{ old('has_diagnosed_disease', 0) == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="has_diagnosed_disease" value="0" {{ old('has_diagnosed_disease', 0) == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal está bajo tratamiento médico actualmente? *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="under_medical_treatment" value="1" {{ old('under_medical_treatment', 0) == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="under_medical_treatment" value="0" {{ old('under_medical_treatment', 0) == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal ha tenido alguna cirugía reciente? *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recent_surgery" value="1" {{ old('recent_surgery', 0) == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="recent_surgery" value="0" {{ old('recent_surgery', 0) == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Tu animal ha sido diagnosticado con alguna de las siguientes enfermedades? (marca todas las que apliquen)</label>
                            <div class="row">
                                @php
                                $diseases = ['Leishmaniasis', 'Ehrlichiosis', 'Parvovirus', 'Anemia', 'Hepatitis', 'Cáncer', 'Otros'];
                                $petDiseases = [];
                                @endphp
                                @foreach($diseases as $disease)
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="diseases[]" value="{{ $disease }}" {{ in_array($disease, old('diseases', $petDiseases)) ? 'checked' : '' }}>
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

                        @if($pet->photo_path)
                        <div class="mb-3">
                            <label class="form-label">Foto actual:</label>
                            <div class="text-center mb-3">
                                <img src="{{ $pet->photo_url }}" alt="Foto de {{ $pet->name }}" class="img-fluid rounded shadow" style="max-height: 300px;">
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="pet_photo" class="form-label">{{ $pet->photo_path ? 'Cambiar foto del animal' : 'Subir foto del animal' }}</label>
                            <input type="file" class="form-control" name="pet_photo" accept=".jpg,.jpeg,.png">
                            <div class="form-text">PNG, JPG hasta 2MB {{ $pet->photo_path ? '(opcional - deja vacío para mantener la foto actual)' : '' }}</div>
                        </div>

                        <div class="alert alert-warning" id="eligibilityWarning" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Advertencia:</strong> <span id="warningMessage"></span>
                        </div>

                        {{-- Información adicional --}}
                        @if($pet->approved_at)
                        <div class="alert alert-success mt-4">
                            <i class="fas fa-check-circle"></i>
                            <strong>Información:</strong> Esta mascota fue aprobada el {{ $pet->approved_at->format('d/m/Y H:i') }}
                        </div>
                        @endif

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Actualizar Información de la Mascota
                            </button>
                            <a href="{{ route('admin.pets.show', $pet->id) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye"></i> Ver Detalles Completos
                            </a>
                            <a href="{{ route('admin.pets') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Listado de Mascotas
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
        const weight = parseFloat(document.querySelector('[name="weight_kg"]').value);
        if (weight && weight < 25) {
            warnings.push('peso insuficiente (mínimo 25kg)');
        }

        // Verificar vacunas
        const vaccines = document.querySelector('[name="vaccines_up_to_date"]:checked');
        if (vaccines && vaccines.value === '0') {
            warnings.push('vacunas no están al día');
        }

        // Verificar estado de salud
        const healthStatus = document.querySelector('[name="health_status"]').value;
        if (healthStatus === 'malo') {
            warnings.push('estado de salud malo');
        }

        if (warnings.length > 0) {
            warningMessage.textContent = `Esta mascota podría no ser apta para donar porque: ${warnings.join(', ')}`;
            warningDiv.style.display = 'block';
        } else {
            warningDiv.style.display = 'none';
        }
    }

    // Agregar event listeners a todos los campos relevantes
    form.addEventListener('change', checkEligibility);
    form.addEventListener('input', checkEligibility);

    // Verificar elegibilidad al cargar la página
    checkEligibility();
});
</script>
@endsection