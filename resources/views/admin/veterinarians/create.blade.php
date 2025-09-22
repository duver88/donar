@extends('layouts.app')

@section('title', 'Crear Veterinario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-md"></i> Crear Nuevo Veterinario
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

                    <form action="{{ route('admin.veterinarians.store') }}" method="POST">
                        @csrf

                        {{-- Datos Personales --}}
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-user"></i> Información Personal
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
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-stethoscope"></i> Información Profesional
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="license_number" class="form-label">Número de Licencia *</label>
                                <input type="text" class="form-control" name="license_number" id="license_number"
                                       value="{{ old('license_number') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialty" class="form-label">Especialidad</label>
                                <input type="text" class="form-control" name="specialty" id="specialty"
                                       value="{{ old('specialty') }}" placeholder="Ej: Cirugía, Cardiología, etc.">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="clinic_name" class="form-label">Nombre de la Clínica *</label>
                                <input type="text" class="form-control" name="clinic_name" id="clinic_name"
                                       value="{{ old('clinic_name') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="years_experience" class="form-label">Años de Experiencia *</label>
                                <input type="number" class="form-control" name="years_experience" id="years_experience"
                                       value="{{ old('years_experience') }}" min="0" max="50" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="clinic_address" class="form-label">Dirección de la Clínica *</label>
                            <textarea class="form-control" name="clinic_address" id="clinic_address" rows="3" required>{{ old('clinic_address') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Crear Veterinario
                            </button>
                            <a href="{{ route('admin.veterinarians') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Listado
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection