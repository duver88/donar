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

                    <form action="{{ route('veterinarian.store') }}" method="POST">
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