{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #EAECB1 0%, #D8E5B0 100%); min-height: 100vh;">
    {{-- Header con Identidad Institucional --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #43883D 0%, #3F8827 100%);">
                <div class="card-body text-white py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                {{-- Escudo de Bucaramanga --}}
                                <div class="me-4">
                                    <div class="bg-white rounded p-2" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-shield-alt" style="color: #43883D; font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="mb-2 fw-bold" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem;">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        Dashboard Super Administrador
                                    </h1>
                                    <p class="mb-0 opacity-90" style="font-size: 1.1rem;">
                                        Alcaldía de Bucaramanga - Sistema de Gestión Veterinaria
                                    </p>
                                    <small class="opacity-75">Panel de control y gestión del sistema</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="text-white-50">
                                <i class="fas fa-calendar-alt me-2"></i>
                                {{ now()->format('d/m/Y') }}
                            </div>
                            <div class="text-white-50">
                                <i class="fas fa-clock me-2"></i>
                                {{ now()->format('H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas con Colores Institucionales --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #F8DC0B 0%, #FCF2B1 100%); transform: translateY(0); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem;">
                                {{ $stats['pending_veterinarians'] }}
                            </h3>
                            <p class="mb-0 fw-semibold">Veterinarios Pendientes</p>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-user-clock" style="font-size: 2rem; color: #285F19;"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-dark border-opacity-25">
                        <small class="d-flex align-items-center">
                            <i class="fas fa-arrow-up me-2 text-danger"></i>
                            <span class="fw-semibold">Requieren aprobación</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #43883D 0%, #3F8827 100%); transform: translateY(0); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem;">
                                {{ $stats['approved_veterinarians'] }}
                            </h3>
                            <p class="mb-0 fw-semibold">Veterinarios Aprobados</p>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-user-md" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white border-opacity-25">
                        <small class="d-flex align-items-center">
                            <i class="fas fa-check me-2"></i>
                            <span class="fw-semibold">Activos en el sistema</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #93C01F 0%, #C7D300 100%); transform: translateY(0); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem;">
                                {{ $stats['total_donors'] }}
                            </h3>
                            <p class="mb-0 fw-semibold">Donantes Aprobados</p>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-dog" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white border-opacity-25">
                        <small class="d-flex align-items-center">
                            <i class="fas fa-heart me-2"></i>
                            <span class="fw-semibold">Listos para donar</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, #285F19 0%, #3F8827 100%); transform: translateY(0); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem;">
                                {{ $stats['active_requests'] }}
                            </h3>
                            <p class="mb-0 fw-semibold">Solicitudes Activas</p>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="fas fa-heartbeat" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top border-white border-opacity-25">
                        <small class="d-flex align-items-center">
                            <i class="fas fa-clock me-2"></i>
                            <span class="fw-semibold">En proceso</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Veterinarios Pendientes --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #43883D 0%, #3F8827 100%);">
                    <h5 class="mb-0 text-white fw-bold" style="font-family: 'Ubuntu', sans-serif;">
                        <i class="fas fa-user-clock me-2"></i>
                        Veterinarios Pendientes de Aprobación
                    </h5>
                </div>
                <div class="card-body">
                    @if($pendingVeterinarians->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr style="background-color: #EAECB1;">
                                        <th class="fw-bold" style="color: #43883D; border-bottom: 2px solid #43883D;">Veterinario</th>
                                        <th class="fw-bold" style="color: #43883D; border-bottom: 2px solid #43883D;">Tarjeta Profesional</th>
                                        <th class="fw-bold" style="color: #43883D; border-bottom: 2px solid #43883D;">Clínica</th>
                                        <th class="fw-bold" style="color: #43883D; border-bottom: 2px solid #43883D;">Ciudad</th>
                                        <th class="fw-bold" style="color: #43883D; border-bottom: 2px solid #43883D;">Fecha Registro</th>
                                        <th class="fw-bold" style="color: #43883D; border-bottom: 2px solid #43883D;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingVeterinarians as $vet)
                                    <tr style="transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#D8E5B0'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td>
                                            <div>
                                                <strong style="color: #285F19;">{{ $vet->name }}</strong><br>
                                                <small class="text-muted"><i class="fas fa-envelope me-1"></i>{{ $vet->email }}</small><br>
                                                <small class="text-muted"><i class="fas fa-phone me-1"></i>{{ $vet->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill" style="background-color: #93C01F; color: #285F19;">
                                                {{ $vet->veterinarian?->professional_card ?? 'N/A' }}
                                            </span>
                                            @if($vet->veterinarian?->professional_card_photo)
                                                <br><small class="text-success"><i class="fas fa-camera"></i> Con foto</small>
                                            @else
                                                <br><small class="text-warning"><i class="fas fa-exclamation-triangle"></i> Sin foto</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong style="color: #285F19;">{{ $vet->veterinarian?->clinic_name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $vet->veterinarian?->clinic_address ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $vet->veterinarian?->city ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $vet->created_at->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.veterinarians.review', $vet->id) }}" 
                                               class="btn btn-sm rounded-pill shadow-sm" 
                                               style="background: linear-gradient(135deg, #43883D 0%, #3F8827 100%); color: white; border: none; transition: transform 0.2s ease;"
                                               onmouseover="this.style.transform='scale(1.05)'" 
                                               onmouseout="this.style.transform='scale(1)'"
                                               title="Revisar solicitud">
                                                <i class="fas fa-eye me-1"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle" style="font-size: 4rem; color: #43883D;"></i>
                            </div>
                            <h5 style="color: #43883D; font-family: 'Ubuntu', sans-serif; font-weight: bold;">
                                No hay veterinarios pendientes
                            </h5>
                            <p class="text-muted">Todas las solicitudes han sido procesadas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Solicitudes Recientes --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #F8DC0B 0%, #FCF2B1 100%);">
                    <h5 class="mb-0 text-dark fw-bold" style="font-family: 'Ubuntu', sans-serif;">
                        <i class="fas fa-history me-2"></i>
                        Solicitudes Recientes
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentRequests->count() > 0)
                        @foreach($recentRequests as $request)
                        <div class="d-flex justify-content-between align-items-start py-3" style="border-bottom: 1px solid #D8E5B0;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold" style="color: #285F19;">{{ $request->patient_name }}</h6>
                                <p class="mb-2 text-muted small">
                                    <i class="fas fa-paw me-1" style="color: #43883D;"></i>
                                    {{ $request->patient_breed }}
                                </p>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="badge rounded-pill" style="background-color: #{{ $request->urgency_color }}; color: white;">
                                        {{ ucfirst($request->urgency_level) }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-user-md me-1"></i>
                                        {{ $request->veterinarian?->user?->name ?? 'Veterinario no disponible' }}
                                    </small>
                                </div>
                            </div>
                            <div class="text-end ms-2">
                                <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox mb-3" style="font-size: 3rem; color: #43883D;"></i>
                            <p class="text-muted mb-0">No hay solicitudes recientes</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer border-0 bg-transparent">
                    <a href="{{ route('admin.blood_requests') }}" 
                       class="btn w-100 rounded-pill shadow-sm" 
                       style="background: linear-gradient(135deg, #93C01F 0%, #C7D300 100%); color: #285F19; border: none; transition: transform 0.2s ease;"
                       onmouseover="this.style.transform='scale(1.02)'" 
                       onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-eye me-2"></i> Ver Todas las Solicitudes
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Enlaces Rápidos --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #285F19 0%, #3F8827 100%);">
                    <h5 class="mb-0 text-white fw-bold" style="font-family: 'Ubuntu', sans-serif;">
                        <i class="fas fa-link me-2"></i>
                        Enlaces Rápidos - Gestión Municipal
                    </h5>
                </div>
                <div class="card-body" style="background: linear-gradient(135deg, #EAECB1 0%, #D8E5B0 100%);">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.veterinarians') }}" 
                               class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4 border-0 rounded-3 shadow-sm text-decoration-none"
                               style="background: white; color: #43883D; transition: all 0.3s ease; min-height: 120px;"
                               onmouseover="this.style.backgroundColor='#43883D'; this.style.color='white'; this.style.transform='translateY(-3px)'" 
                               onmouseout="this.style.backgroundColor='white'; this.style.color='#43883D'; this.style.transform='translateY(0)'">
                                <i class="fas fa-user-md mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Gestionar Veterinarios</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.pets') }}" 
                               class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4 border-0 rounded-3 shadow-sm text-decoration-none"
                               style="background: white; color: #93C01F; transition: all 0.3s ease; min-height: 120px;"
                               onmouseover="this.style.backgroundColor='#93C01F'; this.style.color='white'; this.style.transform='translateY(-3px)'" 
                               onmouseout="this.style.backgroundColor='white'; this.style.color='#93C01F'; this.style.transform='translateY(0)'">
                                <i class="fas fa-dog mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Gestionar Mascotas</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.blood_requests') }}" 
                               class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4 border-0 rounded-3 shadow-sm text-decoration-none"
                               style="background: white; color: #F8DC0B; transition: all 0.3s ease; min-height: 120px;"
                               onmouseover="this.style.backgroundColor='#F8DC0B'; this.style.color='#285F19'; this.style.transform='translateY(-3px)'"
                               onmouseout="this.style.backgroundColor='white'; this.style.color='#F8DC0B'; this.style.transform='translateY(0)'">
                                <i class="fas fa-heartbeat mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold" style="color: #285F19;">Ver Solicitudes</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('home') }}" 
                               class="btn w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4 border-0 rounded-3 shadow-sm text-decoration-none"
                               style="background: white; color: #285F19; transition: all 0.3s ease; min-height: 120px;"
                               onmouseover="this.style.backgroundColor='#285F19'; this.style.color='white'; this.style.transform='translateY(-3px)'" 
                               onmouseout="this.style.backgroundColor='white'; this.style.color='#285F19'; this.style.transform='translateY(0)'">
                                <i class="fas fa-home mb-2" style="font-size: 2rem;"></i>
                                <span class="fw-bold">Ver Sitio Público</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 text-center" style="background: transparent;">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1" style="color: #43883D;"></i>
                        Alcaldía de Bucaramanga - Montani Semper Liberi
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilos adicionales para fuentes Ubuntu --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap');

* {
    font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border-radius: 12px !important;
    overflow: hidden;
}

.btn {
    font-weight: 500;
}

.table th {
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge {
    font-weight: 500;
    font-size: 0.75rem;
}

.card-header h5 {
    font-size: 1.1rem;
    letter-spacing: 0.3px;
}

/* Animaciones suaves */
.card, .btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Scrollbar personalizado */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #43883D;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #3F8827;
}
</style>
@endsection