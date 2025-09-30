{{-- resources/views/public/active-requests.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Activas - Banco de Sangre Canina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --verde-principal: #43883D;
            --verde-claro: #93C01F;
            --amarillo: #F8DC0B;
            --rojo: #C20E1A;
        }

        body {
            font-family: 'Ubuntu', sans-serif;
            background: #fafafa;
            line-height: 1.6;
        }

        .header-minimal {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 0;
        }

        .hero-minimal {
            background: var(--verde-principal);
            color: white;
            padding: 3rem 0;
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
</head>
<body>
    {{-- Header Minimalista --}}
    <div class="header-minimal">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--verde-principal);">
                    <h1 class="h4 mb-0 fw-medium">
                        <i class="fas fa-heart me-2"></i>
                        Banco de Sangre Canina
                    </h1>
                </a>
                <a href="{{ route('pets.create') }}" class="btn btn-primary-minimal">
                    <i class="fas fa-plus me-1"></i>Registrar Donante
                </a>
            </div>
        </div>
    </div>

    {{-- Hero Simplificado --}}
    <div class="hero-minimal">
        <div class="container text-center">
            <h2 class="mb-3 fw-light">Casos que necesitan tu ayuda</h2>
            <p class="mb-0 opacity-90">
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

    {{-- Footer Minimalista --}}
    <footer class="border-top py-4 mt-5" style="background: white;">
        <div class="container text-center">
            <p class="text-muted small mb-0">
                <strong style="color: var(--verde-principal);">Banco de Sangre Canina</strong> • Salvando vidas juntos
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>