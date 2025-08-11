{{-- resources/views/tutor/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Mi Dashboard - Tutor')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-dog text-info"></i> Mi Dashboard</h2>
                    <p class="text-muted mb-0">Bienvenido, {{ Auth::user()->name }}</p>
                </div>
                <div>
                    <a href="{{ route('pets.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Registrar Nueva Mascota
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    @if(isset($stats))
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['my_pets'] ?? 0 }}</h4>
                            <p class="mb-0">Mis Mascotas</p>
                        </div>
                        <div>
                            <i class="fas fa-dog fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['approved_donors'] ?? 0 }}</h4>
                            <p class="mb-0">Donantes Aprobados</p>
                        </div>
                        <div>
                            <i class="fas fa-heart fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_donations'] ?? 0 }}</h4>
                            <p class="mb-0">Donaciones Realizadas</p>
                        </div>
                        <div>
                            <i class="fas fa-gift fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $stats['pending_requests'] ?? 0 }}</h4>
                            <p class="mb-0">Solicitudes Pendientes</p>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        {{-- Mis Mascotas --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-paw text-info"></i> Mis Mascotas Registradas</h5>
                    <a href="{{ route('pets.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Agregar Mascota
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($pets) && $pets->count() > 0)
                        <div class="row">
                            @foreach($pets as $pet)
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                @if($pet->photo_path)
                                                    <img src="{{ Storage::url($pet->photo_path) }}" 
                                                         alt="{{ $pet->name }}" 
                                                         class="rounded-circle" 
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-dog fa-2x"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $pet->name }}</h6>
                                                <p class="text-muted mb-1 small">{{ $pet->breed }} - {{ $pet->weight_kg }}kg</p>
                                                <span class="badge bg-{{ $pet->donor_status === 'approved' ? 'success' : ($pet->donor_status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ $pet->status_display }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-dog fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes mascotas registradas</h5>
                            <p class="text-muted mb-3">Registra a tu primera mascota como donante</p>
                            <a href="{{ route('pets.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Registrar Mi Primera Mascota
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Solicitudes Recientes --}}
            <div class="card shadow mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-history text-warning"></i> Solicitudes Recientes</h5>
                </div>
                <div class="card-body">
                    @if(isset($recentRequests) && $recentRequests->count() > 0)
                        @foreach($recentRequests as $response)
                        <div class="border-bottom py-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $response->bloodRequest->patient_name }}</h6>
                                    <small class="text-muted">Con {{ $response->pet->name }}</small><br>
                                    <span class="badge bg-{{ $response->response_color }}">
                                        {{ $response->response_display }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $response->responded_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No hay solicitudes recientes</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Información Útil --}}
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle text-info"></i> Información Útil</h5>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-heart text-danger"></i> ¿Cómo funciona la donación?</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i> 
                            Recibes emails cuando hay solicitudes
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i> 
                            Decides si tu mascota puede ayudar
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i> 
                            Coordinas directamente con el veterinario
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success"></i> 
                            El proceso es seguro y supervisado
                        </li>
                    </ul>
                    
                    <hr>
                    
                    <h6><i class="fas fa-phone text-primary"></i> ¿Necesitas ayuda?</h6>
                    <p class="small text-muted mb-0">
                        Si tienes preguntas sobre el proceso de donación o necesitas actualizar los datos de tu mascota, 
                        contáctanos y te ayudaremos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection