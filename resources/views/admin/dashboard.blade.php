{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-vh-100" style="background: #fafafa;">
    {{-- Header Minimalista --}}
    <div class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="mb-2 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.2rem; color: #43883D;">
                        Panel de Administración
                    </h1>
                    <p class="text-muted mb-0" style="font-size: 1rem;">
                        Alcaldía de Bucaramanga • Sistema Veterinario
                    </p>
                </div>
                <div class="text-end">
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">{{ now()->format('d/m/Y • H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas Principales --}}
    <div class="container-fluid px-4 mb-4">
        <div class="row g-3">
            {{-- Veterinarios Pendientes --}}
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #F8DC0B;">
                            {{ $stats['pending_veterinarians'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Veterinarios Pendientes</p>
                        @if($stats['pending_veterinarians'] > 0)
                            <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.75rem;">
                                Requieren revisión
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Veterinarios Aprobados --}}
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #43883D;">
                            {{ $stats['approved_veterinarians'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Veterinarios Activos</p>
                        <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.75rem;">
                            Operando
                        </span>
                    </div>
                </div>
            </div>

            {{-- Donantes Aprobados --}}
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #93C01F;">
                            {{ $stats['total_donors'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Donantes Disponibles</p>
                        <span class="badge" style="background: rgba(147, 192, 31, 0.1); color: #93C01F; font-size: 0.75rem;">
                            Listos
                        </span>
                    </div>
                </div>
            </div>

            {{-- Solicitudes Activas --}}
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 h-100" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-body p-4 text-center">
                        <h2 class="mb-1 fw-light" style="font-family: 'Ubuntu', sans-serif; font-size: 2.5rem; color: #C20E1A;">
                            {{ $stats['active_requests'] }}
                        </h2>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">Solicitudes Urgentes</p>
                        @if($stats['active_requests'] > 0)
                            <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.75rem;">
                                En proceso
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido Principal --}}
    <div class="container-fluid px-4">
        <div class="row g-4">
            {{-- Panel de Veterinarios Pendientes --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0" style="border-radius: 12px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-header border-0 py-3" style="background: transparent;">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-normal" style="font-family: 'Ubuntu', sans-serif; font-size: 1.2rem; color: #43883D;">
                                Veterinarios Pendientes
                            </h5>
                            @if($pendingVeterinarians->count() > 0)
                                <span class="badge" style="background: rgba(248, 220, 11, 0.1); color: #F8DC0B; font-size: 0.8rem;">
                                    {{ $pendingVeterinarians->count() }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if($pendingVeterinarians->count() > 0)
                            <div class="space-y-3">
                                @foreach($pendingVeterinarians as $vet)
                                <div class="d-flex align-items-center p-3 rounded" style="background: #f8f9fa; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="mb-1 fw-medium" style="color: #43883D; font-size: 0.95rem;">
                                                    {{ $vet->name }}
                                                </h6>
                                                <p class="text-muted small mb-1">{{ $vet->veterinarian?->clinic_name ?? 'Sin clínica' }}</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge" style="background: rgba(67, 136, 61, 0.1); color: #43883D; font-size: 0.7rem;">
                                                        {{ $vet->veterinarian?->professional_card ?? 'N/A' }}
                                                    </span>
                                                    <span class="text-muted" style="font-size: 0.75rem;">
                                                        {{ $vet->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.veterinarians.review', $vet->id) }}"
                                                   class="btn btn-sm"
                                                   style="background: #43883D; color: white; border: none; border-radius: 8px; font-size: 0.85rem; padding: 8px 16px; font-weight: 500;">
                                                    Revisar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted mb-3">
                                    <i class="fas fa-check-circle" style="font-size: 3rem; color: #43883D;"></i>
                                </div>
                                <h6 class="fw-medium mb-2" style="color: #43883D;">Todo al día</h6>
                                <p class="text-muted small mb-3">No hay veterinarios pendientes</p>
                                <a href="{{ route('admin.veterinarians') }}"
                                   class="btn btn-sm"
                                   style="background: transparent; color: #43883D; border: 1px solid #43883D; border-radius: 8px; font-size: 0.85rem; padding: 8px 16px; font-weight: 500;">
                                    Ver todos
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Panel de Actividad Reciente --}}
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0" style="border-radius: 12px; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div class="card-header border-0 py-3" style="background: transparent;">
                        <h5 class="mb-0 fw-normal" style="font-family: 'Ubuntu', sans-serif; font-size: 1.2rem; color: #43883D;">
                            Actividad Reciente
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        @if($recentRequests->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentRequests as $request)
                                <div class="p-3 rounded" style="background: #f8f9fa; border-left: 3px solid #43883D;">
                                    <h6 class="mb-1 fw-medium" style="color: #43883D; font-size: 0.9rem;">
                                        {{ $request->patient_name }}
                                    </h6>
                                    <p class="text-muted small mb-2">{{ $request->patient_breed ?? 'Sin raza' }}</p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge" style="background: rgba(194, 14, 26, 0.1); color: #C20E1A; font-size: 0.7rem;">
                                            {{ ucfirst($request->urgency_level) }}
                                        </span>
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            {{ $request->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="text-muted mb-3">
                                    <i class="fas fa-inbox" style="font-size: 2.5rem; color: #43883D;"></i>
                                </div>
                                <h6 class="fw-medium mb-2" style="color: #43883D;">Sin actividad</h6>
                                <p class="text-muted small mb-0">No hay solicitudes recientes</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer border-0 bg-transparent p-3">
                        <a href="{{ route('admin.blood_requests') }}"
                           class="btn w-100 btn-sm"
                           style="background: #43883D; color: white; border: none; border-radius: 8px; font-size: 0.85rem; padding: 12px; font-weight: 500;">
                           Ver todas las solicitudes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Acciones Rápidas --}}
    <div class="container-fluid px-4 py-3">
        <div class="row g-3">
            {{-- Gestionar Veterinarios --}}
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.veterinarians') }}"
                   class="card border-0 text-decoration-none h-100"
                   style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(67, 136, 61, 0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-user-md" style="font-size: 2.5rem; color: #43883D;"></i>
                        </div>
                        <h6 class="fw-medium mb-2" style="color: #43883D; font-size: 1rem;">
                            Gestionar Veterinarios
                        </h6>
                        <p class="text-muted small mb-0">Revisar y aprobar veterinarios</p>
                    </div>
                </a>
            </div>

            {{-- Gestionar Mascotas --}}
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.pets') }}"
                   class="card border-0 text-decoration-none h-100"
                   style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(147, 192, 31, 0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-dog" style="font-size: 2.5rem; color: #93C01F;"></i>
                        </div>
                        <h6 class="fw-medium mb-2" style="color: #93C01F; font-size: 1rem;">
                            Gestionar Mascotas
                        </h6>
                        <p class="text-muted small mb-0">Administrar donantes y registros</p>
                    </div>
                </a>
            </div>

            {{-- Ver Solicitudes --}}
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.blood_requests') }}"
                   class="card border-0 text-decoration-none h-100"
                   style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(248, 220, 11, 0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-heartbeat" style="font-size: 2.5rem; color: #F8DC0B;"></i>
                        </div>
                        <h6 class="fw-medium mb-2" style="color: #F8DC0B; font-size: 1rem;">
                            Ver Solicitudes
                        </h6>
                        <p class="text-muted small mb-0">Monitorear solicitudes de sangre</p>
                    </div>
                </a>
            </div>

            {{-- Ver Sitio Público --}}
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('home') }}"
                   class="card border-0 text-decoration-none h-100"
                   style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(194, 14, 26, 0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-globe" style="font-size: 2.5rem; color: #C20E1A;"></i>
                        </div>
                        <h6 class="fw-medium mb-2" style="color: #C20E1A; font-size: 1rem;">
                            Sitio Público
                        </h6>
                        <p class="text-muted small mb-0">Ver la interfaz pública</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Footer Institucional --}}
    <div class="container-fluid px-4 py-3 mt-3">
        <div class="card border-0" style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="card-body text-center py-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="me-3">
                        <i class="fas fa-shield-alt" style="color: #43883D; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium" style="color: #43883D; font-size: 1.1rem;">
                            Alcaldía de Bucaramanga
                        </p>
                        <small class="text-muted">Montani Semper Liberi - Sistema de Gestión Veterinaria</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estilos optimizados para el dashboard --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');

/* Variables CSS para colores consistentes */
:root {
    --primary-green: #43883D;
    --primary-yellow: #F8DC0B;
    --primary-light-green: #93C01F;
    --primary-red: #C20E1A;
    --card-shadow: 0 1px 3px rgba(0,0,0,0.1);
    --card-shadow-hover: 0 4px 12px rgba(67, 136, 61, 0.15);
    --border-radius: 12px;
}

/* Fuente base */
* {
    font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Cards consistentes */
.card {
    border-radius: var(--border-radius) !important;
    box-shadow: var(--card-shadow);
    border: none;
    overflow: hidden;
}

/* Botones estandarizados */
.btn {
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
}

/* Badges consistentes */
.badge {
    font-weight: 500;
    font-size: 0.75rem;
    border-radius: 6px;
}

/* Animaciones suaves */
.card:hover {
    transform: translateY(-1px);
}

/* Scrollbar personalizado */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: var(--primary-green);
    border-radius: 6px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #285F19;
}

/* Mejoras de tipografía */
h1, h2, h3, h4, h5, h6 {
    font-family: 'Ubuntu', sans-serif;
}

/* Espaciado consistente */
.space-y-3 > * + * {
    margin-top: 0.75rem;
}
</style>
@endsection