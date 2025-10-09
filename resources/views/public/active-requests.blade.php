{{-- resources/views/public/active-requests.blade.php --}}
@extends('layouts.app')

@section('title', 'Solicitudes Activas - Banco de Sangre Canina')

@section('content')
<style>
    :root {
        --verde-principal: #43883D;
        --verde-claro: #93C01F;
        --amarillo: #F8DC0B;
        --rojo: #C20E1A;
    }

    body {
        background: #fafafa;
    }

    .hero-minimal {
        background: linear-gradient(135deg, var(--verde-principal) 0%, #51AD32 100%);
        color: white;
        padding: 4rem 0;
        position: relative;
    }

    .hero-minimal::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .hero-minimal .container {
        position: relative;
        z-index: 2;
    }

        .card-minimal {
            background: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .card-minimal:hover {
            transform: translateY(-2px);
        }

        .urgency-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .urgency-critica { background: rgba(194, 14, 26, 0.1); color: #C20E1A; }
        .urgency-alta { background: rgba(248, 220, 11, 0.1); color: #856404; }
        .urgency-media { background: rgba(147, 192, 31, 0.1); color: #93C01F; }
        .urgency-baja { background: rgba(67, 136, 61, 0.1); color: #43883D; }

        .blood-type-badge {
            background: var(--verde-principal);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-block;
        }

        .btn-primary-minimal {
            background: var(--verde-principal);
            border: none;
            color: white;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
        }

        .btn-primary-minimal:hover {
            background: #3a7635;
            color: white;
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--verde-principal);
            box-shadow: 0 0 0 0.2rem rgba(67, 136, 61, 0.1);
        }
</style>

{{-- Hero con diseño mejorado --}}
<div class="hero-minimal">
    <div class="container text-center">
        <div class="d-flex justify-content-center align-items-center mb-4 gap-4">
            <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/06/escudo-alcaldia.png"
                 alt="Escudo Alcaldía de Bucaramanga"
                 style="height: 80px;">
            <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/10/Dognar-Logo-04.png"
                 alt="Dognar Logo"
                 style="height: 120px; background: white; border-radius: 15px; padding: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>
        <h2 class="mb-3 fw-light" style="color: white;">Casos que necesitan tu ayuda</h2>
        <p class="mb-0 opacity-90" style="font-size: 1.1rem; color: white;">
            <strong>{{ $activeRequests->total() }}</strong> solicitudes activas • Tu mascota puede salvar una vida
        </p>
    </div>
</div>

    {{-- Filtros Minimalistas --}}
    <div class="container py-4">
        <div class="card-minimal p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tipo de Sangre</label>
                    <select name="blood_type" class="form-select">
                        <option value="">Todos</option>
                        <option value="DEA 1.1 Positivo">DEA 1.1 Positivo</option>
                        <option value="DEA 1.1 Negativo">DEA 1.1 Negativo</option>
                        <option value="DEA 4 Positivo">DEA 4 Positivo</option>
                        <option value="DEA 7 Positivo">DEA 7 Positivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Urgencia</label>
                    <select name="urgency" class="form-select">
                        <option value="">Todas</option>
                        <option value="critica">Crítica</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">Ciudad</label>
                    <input type="text" name="city" class="form-control" placeholder="Ej: Bucaramanga">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-minimal w-100">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de Solicitudes Minimalista --}}
    <div class="container pb-5">
        @if($activeRequests->count() > 0)
            <div class="row g-3">
                @foreach($activeRequests as $request)
                    <div class="col-lg-6 col-xl-4">
                        <div class="card-minimal p-4 h-100">
                            {{-- Nombre del paciente --}}
                            <div class="mb-3">
                                <h5 class="mb-1 fw-medium" style="color: var(--verde-principal);">
                                    {{ $request->patient_name }}
                                </h5>
                                <p class="text-muted mb-0">{{ $request->patient_breed ?? 'Sin raza especificada' }}</p>
                            </div>

                            {{-- Tiempo publicado --}}
                            <div class="mb-3">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-clock me-2"></i>
                                    <span>Publicado {{ $request->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            {{-- Tiempo límite --}}
                            <div class="mb-4">
                                @if($request->needed_by_date)
                                    <div class="d-flex align-items-center {{ $request->needed_by_date < now() ? 'text-danger' : 'text-muted' }} small">
                                        <i class="fas fa-calendar-times me-2"></i>
                                        <span>
                                            <strong>Límite:</strong> {{ $request->needed_by_date->format('d/m/Y H:i') }}
                                            <br>
                                            <small>({{ $request->needed_by_date->diffForHumans() }})</small>
                                        </span>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="fas fa-calendar me-2"></i>
                                        <span>Sin fecha límite especificada</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Botón de acción --}}
                            <div class="mt-auto">
                                <a href="{{ route('pets.create') }}" class="btn btn-primary-minimal w-100 mb-2">
                                    <i class="fas fa-heart me-2"></i>Quiero ayudar
                                </a>
                                <p class="text-muted small text-center mb-0">
                                    Registra tu mascota como donante
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación Simple --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $activeRequests->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4" style="color: var(--verde-principal);">
                    <i class="fas fa-check-circle" style="font-size: 3rem;"></i>
                </div>
                <h5 class="fw-medium mb-3" style="color: var(--verde-principal);">¡Excelente noticia!</h5>
                <p class="text-muted mb-4">No hay solicitudes urgentes en este momento.</p>
                <a href="{{ route('pets.create') }}" class="btn btn-primary-minimal">
                    Registrar mi mascota como donante
                </a>
            </div>
        @endif
    </div>

@endsection