@extends('layouts.app')

@section('title', 'Inicio - Banco de Sangre Canina')

@section('content')
<div class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">
            <i class="fas fa-heart text-danger"></i> Banco de Sangre Canina
        </h1>
        <p class="lead mb-5">Conectamos mascotas sanas con aquellas que necesitan una segunda oportunidad de vida</p>
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 card-hover shadow">
                            <div class="card-body text-center text-dark">
                                <i class="fas fa-dog fa-4x text-primary mb-4"></i>
                                <h4 class="card-title text-primary">¿Tu mascota puede ser donante?</h4>
                                <p class="card-text">Registra a tu mascota como donante y ayuda a salvar vidas. Es un proceso seguro y controlado por veterinarios.</p>
                                <a href="{{ route('pets.create') }}" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle"></i> Postular mi mascota
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card h-100 card-hover shadow">
                            <div class="card-body text-center text-dark">
                                <i class="fas fa-user-md fa-4x text-success mb-4"></i>
                                <h4 class="card-title text-success">¿Eres veterinario?</h4>
                                <p class="card-text">Solicita donaciones de sangre para tus pacientes de manera rápida y eficiente.</p>
                                @auth
                                    @if(Auth::user()->role === 'veterinarian' && Auth::user()->status === 'approved')
                                        <a href="{{ route('veterinarian.blood_request.create') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-heartbeat"></i> Solicitar donación
                                        </a>
                                    @else
                                        <a href="{{ route('veterinarian.register') }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-user-plus"></i> Registrarse
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('veterinarian.register') }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-user-plus"></i> Registrarse
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estadísticas --}}
@if(isset($stats))
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-dog fa-3x text-primary mb-3"></i>
                        <h3 class="text-primary">{{ $stats['total_donors'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Donantes Registrados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-user-md fa-3x text-success mb-3"></i>
                        <h3 class="text-success">{{ $stats['total_veterinarians'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Veterinarios Activos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-heartbeat fa-3x text-danger mb-3"></i>
                        <h3 class="text-danger">{{ $stats['active_requests'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Solicitudes Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                        <h3 class="text-info">{{ $stats['total_tutors'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Tutores Registrados</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Información sobre donación --}}
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4">¿Por qué es importante la donación de sangre canina?</h2>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <i class="fas fa-check-circle text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5>Salva vidas en emergencias</h5>
                                <p class="text-muted">Accidentes, cirugías complejas y enfermedades graves requieren transfusiones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <i class="fas fa-shield-alt text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5>Proceso seguro</h5>
                                <p class="text-muted">Todos los donantes pasan por evaluación médica completa.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <i class="fas fa-clock text-success fa-2x me-3 mt-1"></i>
                            <div>
                                <h5>Respuesta rápida</h5>
                                <p class="text-muted">Conectamos donantes con necesidades urgentes en tiempo real.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <img src="https://via.placeholder.com/500x400/667eea/ffffff?text=Perros+Donantes" 
                         class="img-fluid rounded shadow" alt="Perros donantes">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Proceso de donación --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">¿Cómo funciona?</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white p-4 rounded shadow h-100">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <span class="fs-4 fw-bold">1</span>
                    </div>
                    <h5>Registra tu mascota</h5>
                    <p class="text-muted">Completa el formulario con los datos de tu mascota. Verificamos que sea apta para donar.</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white p-4 rounded shadow h-100">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <span class="fs-4 fw-bold">2</span>
                    </div>
                    <h5>Recibe notificaciones</h5>
                    <p class="text-muted">Te contactamos cuando hay una mascota cerca que necesita ayuda de tu donante.</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white p-4 rounded shadow h-100">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <span class="fs-4 fw-bold">3</span>
                    </div>
                    <h5>Salva una vida</h5>
                    <p class="text-muted">Coordinas con el veterinario y tu mascota ayuda a salvar la vida de otro perrito.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection