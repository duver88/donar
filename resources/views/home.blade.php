@extends('layouts.app')

@section('title', 'Inicio - Banco de Sangre Canina')

@section('content')
<div class="hero-section">
    <div class="container text-center">
        <div class="d-flex justify-content-center align-items-center mb-4 gap-4">
            <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/06/escudo-alcaldia.png"
                 alt="Escudo Alcaldía de Bucaramanga"
                 style="height: 100px;">
            <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/10/Dognar-Logo-04.png"
                 alt="Dognar Logo"
                 style="height: 150px; background: white; border-radius: 15px; padding: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>
        <p class="lead mb-5">Conectamos mascotas sanas con aquellas que necesitan una segunda oportunidad de vida</p>
        
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 card-hover shadow" style="background: linear-gradient(135deg, #43883D 0%, #51AD32 100%); border: none;">
                            <div class="card-body text-center text-white">
                                <i class="fas fa-dog fa-4x mb-4" style="color: #F8DC0B;"></i>
                                <h4 class="card-title" style="color: white;">¿Tu mascota puede ser donante?</h4>
                                <p class="card-text">Registra a tu mascota como donante y ayuda a salvar vidas. Es un proceso seguro y controlado por veterinarios.</p>
                                <a href="{{ route('pets.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #F8DC0B 0%, #FCF2B1 100%); border: none; color: #285F19; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(248, 220, 11, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(248, 220, 11, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(248, 220, 11, 0.3)'"
                                    <i class="fas fa-plus-circle"></i> Postular mi mascota
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 card-hover shadow">
                            <div class="card-body text-center text-dark">
                                <i class="fas fa-heart fa-4x mb-4" style="color: #C20E1A;"></i>
                                <h4 class="card-title" style="color: #C20E1A;">Ver casos que necesitan ayuda</h4>
                                <p class="card-text">Explora las solicitudes activas de donación y descubre cómo tu mascota puede ayudar a salvar vidas.</p>
                                <a href="{{ route('public.active-requests') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #C20E1A 0%, #E53E3E 100%); border: none; color: white; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(194, 14, 26, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(194, 14, 26, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(194, 14, 26, 0.3)'"
                                    <i class="fas fa-list"></i> Ver solicitudes activas
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card h-100 card-hover shadow">
                            <div class="card-body text-center text-dark">
                                <i class="fas fa-user-md fa-4x mb-4" style="color: #285F19;"></i>
                                <h4 class="card-title" style="color: #285F19;">¿Eres veterinario?</h4>
                                <p class="card-text">Solicita donaciones de sangre para tus pacientes de manera rápida y eficiente.</p>
                                @auth
                                    @if(Auth::user()->role === 'veterinarian' && Auth::user()->status === 'approved')
                                        <a href="{{ route('veterinarian.blood_request.create') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #93C01F 0%, #C7D300 100%); border: none; color: #285F19; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(147, 192, 31, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(147, 192, 31, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(147, 192, 31, 0.3)'"
                                            <i class="fas fa-heartbeat"></i> Solicitar donación
                                        </a>
                                    @else
                                        <a href="{{ route('veterinarian.register') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #93C01F 0%, #C7D300 100%); border: none; color: #285F19; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(147, 192, 31, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(147, 192, 31, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(147, 192, 31, 0.3)'">
                                            <i class="fas fa-user-plus"></i> Registrarse
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('veterinarian.register') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #93C01F 0%, #C7D300 100%); border: none; color: #285F19; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(147, 192, 31, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(147, 192, 31, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(147, 192, 31, 0.3)'">
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
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body">
                        <i class="fas fa-dog fa-3x mb-3" style="color: #43883D;"></i>
                        <h3 style="color: #43883D;">{{ $stats['total_donors'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Donantes Registrados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body">
                        <i class="fas fa-user-md fa-3x mb-3" style="color: #285F19;"></i>
                        <h3 style="color: #285F19;">{{ $stats['total_veterinarians'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Veterinarios Activos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body">
                        <i class="fas fa-heartbeat fa-3x mb-3" style="color: #C20E1A;"></i>
                        <h3 style="color: #C20E1A;">{{ $stats['active_requests'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Solicitudes Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm stats-card">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x mb-3" style="color: #868686;"></i>
                        <h3 style="color: #868686;">{{ $stats['total_tutors'] ?? 0 }}</h3>
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
                            <i class="fas fa-check-circle fa-2x me-3 mt-1" style="color: #43883D;"></i>
                            <div>
                                <h5>Salva vidas en emergencias</h5>
                                <p class="text-muted">Accidentes, cirugías complejas y enfermedades graves requieren transfusiones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <i class="fas fa-shield-alt fa-2x me-3 mt-1" style="color: #43883D;"></i>
                            <div>
                                <h5>Proceso seguro</h5>
                                <p class="text-muted">Todos los donantes pasan por evaluación médica completa.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex">
                            <i class="fas fa-clock fa-2x me-3 mt-1" style="color: #43883D;"></i>
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
                    <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/10/Dognar-salva-imagen.png"
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
                    <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="background: linear-gradient(135deg, #43883D 0%, #51AD32 100%); width: 60px; height: 60px;"
                        <span class="fs-4 fw-bold">1</span>
                    </div>
                    <h5>Registra tu mascota</h5>
                    <p class="text-muted">Completa el formulario con los datos de tu mascota. Verificamos que sea apta para donar.</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white p-4 rounded shadow h-100">
                    <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="background: linear-gradient(135deg, #93C01F 0%, #C7D300 100%); width: 60px; height: 60px;"
                        <span class="fs-4 fw-bold">2</span>
                    </div>
                    <h5>Recibe notificaciones</h5>
                    <p class="text-muted">Te contactamos cuando hay una mascota cerca que necesita ayuda de tu donante.</p>
                </div>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white p-4 rounded shadow h-100">
                    <div class="text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="background: linear-gradient(135deg, #C20E1A 0%, #E53E3E 100%); width: 60px; height: 60px;"
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