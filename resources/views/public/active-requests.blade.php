{{-- resources/views/public/active-requests.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Activas - Banco de Sangre Canina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Variables de color institucionales Alcaldía de Bucaramanga */
        :root {
            --bucaramanga-verde-principal: #43883D;
            --bucaramanga-verde-claro: #51AD32;
            --bucaramanga-verde-oscuro: #3F8827;
            --bucaramanga-verde-mas-claro: #93C01F;
            --bucaramanga-verde-muy-claro: #C7D300;
            --bucaramanga-amarillo: #F8DC0B;
            --bucaramanga-rojo: #C20E1A;
            --bucaramanga-gris: #868686;
            --bucaramanga-gris-claro: #EAECB1;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 50%, var(--bucaramanga-verde-mas-claro) 100%);
            color: white;
            padding: 60px 0;
            position: relative;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(248, 220, 11, 0.1) 0%, transparent 50%);
        }
        .urgency-badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .urgency-alta { background-color: #C20E1A; }
        .urgency-media { background-color: #F8DC0B; color: #285F19; }
        .urgency-baja { background-color: #43883D; }
        .request-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .blood-type {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(67, 136, 61, 0.3);
        }

        /* Botones con colores institucionales */
        .btn-bucaramanga-primary {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(67, 136, 61, 0.3);
        }
        .btn-bucaramanga-primary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-verde-oscuro) 0%, var(--bucaramanga-verde-principal) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 136, 61, 0.4);
            color: white;
        }

        .btn-bucaramanga-secondary {
            background: linear-gradient(135deg, var(--bucaramanga-verde-mas-claro) 0%, var(--bucaramanga-verde-muy-claro) 100%);
            border: none;
            color: #285F19;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(147, 192, 31, 0.3);
        }
        .btn-bucaramanga-secondary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-verde-muy-claro) 0%, var(--bucaramanga-verde-mas-claro) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(147, 192, 31, 0.4);
            color: #285F19;
        }

        /* Elementos de acento */
        .text-bucaramanga-green { color: var(--bucaramanga-verde-principal) !important; }
        .text-bucaramanga-blue { color: var(--bucaramanga-verde-oscuro) !important; }
        .text-bucaramanga-gold { color: var(--bucaramanga-amarillo) !important; }
        .bg-bucaramanga-green { background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%) !important; }
        .bg-bucaramanga-blue { background: linear-gradient(135deg, var(--bucaramanga-verde-oscuro) 0%, var(--bucaramanga-verde-principal) 100%) !important; }
    </style>
</head>
<body>
    {{-- Header Hero --}}
    <div class="hero-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-4 mb-4">
                        <i class="fas fa-heart text-light me-3"></i>
                        Casos que necesitan tu ayuda
                    </h1>
                    <p class="lead mb-4">
                        Hay <strong>{{ $activeRequests->total() }}</strong> solicitudes activas de donación de sangre canina.
                        Tu mascota puede salvar una vida hoy.
                    </p>
                    <div class="row text-center mt-4">
                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <i class="fas fa-dog fa-2x mb-2"></i>
                                <h5>Donantes Registrados</h5>
                                <span class="h4">150+</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <i class="fas fa-hospital fa-2x mb-2"></i>
                                <h5>Veterinarias Aliadas</h5>
                                <span class="h4">25+</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-20 rounded p-3">
                                <i class="fas fa-heart fa-2x mb-2"></i>
                                <h5>Vidas Salvadas</h5>
                                <span class="h4">200+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Navegación --}}
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background: linear-gradient(90deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-oscuro) 100%);">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">
                <i class="fas fa-home me-2 text-bucaramanga-gold"></i>Banco de Sangre Canina
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white fw-semibold" href="{{ route('pets.create') }}" style="background: rgba(255,255,255,0.2); border-radius: 0.5rem; padding: 0.5rem 1rem; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    <i class="fas fa-plus me-1"></i>Registrar Donante
                </a>
            </div>
        </div>
    </nav>

    {{-- Filtros --}}
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="bg-light p-3 rounded">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Sangre</label>
                            <select name="blood_type" class="form-select">
                                <option value="">Todos los tipos</option>
                                <option value="DEA 1.1 Positivo">DEA 1.1 Positivo</option>
                                <option value="DEA 1.1 Negativo">DEA 1.1 Negativo</option>
                                <option value="DEA 4 Positivo">DEA 4 Positivo</option>
                                <option value="DEA 7 Positivo">DEA 7 Positivo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Urgencia</label>
                            <select name="urgency" class="form-select">
                                <option value="">Todas las urgencias</option>
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="city" class="form-control" placeholder="Ej: Bucaramanga">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-bucaramanga-primary me-2">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('public.active-requests') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de Solicitudes --}}
    <div class="container my-5">
        @if($activeRequests->count() > 0)
            <div class="row">
                @foreach($activeRequests as $request)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card request-card h-100">
                            {{-- Header de la tarjeta --}}
                            <div class="card-header bg-white border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1">{{ $request->patient_name }}</h5>
                                        <small class="text-muted">{{ $request->patient_breed }}</small>
                                    </div>
                                    <span class="urgency-badge urgency-{{ $request->urgency_level }}">
                                        {{ $request->urgency_level }}
                                    </span>
                                </div>
                                <div class="blood-type mt-2">
                                    🩸 {{ $request->blood_type }}
                                </div>
                            </div>

                            {{-- Cuerpo de la tarjeta --}}
                            <div class="card-body">
                                {{-- Información del veterinario --}}
                                <div class="mb-3">
                                    <div class="small text-muted">
                                        <i class="fas fa-user-md me-1"></i>
                                        <strong>Dr. {{ $request->veterinarian->name ?? 'No especificado' }}</strong>
                                    </div>
                                    @if($request->veterinarian && $request->veterinarian->clinic_name)
                                        <div class="small text-muted">
                                            <i class="fas fa-hospital me-1"></i>{{ $request->veterinarian->clinic_name }}
                                        </div>
                                    @endif
                                    @if($request->veterinarian && $request->veterinarian->clinic_address)
                                        <div class="small text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $request->veterinarian->clinic_address }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Descripción --}}
                                <p class="card-text">
                                    <strong>Situación:</strong><br>
                                    {{ Str::limit($request->medical_reason, 120) }}
                                </p>

                                {{-- Información adicional --}}
                                <div class="small text-muted mb-3">
                                    <div><i class="fas fa-clock me-1"></i>Solicitado {{ $request->created_at->diffForHumans() }}</div>
                                    @if($request->needed_by_date)
                                        <div><i class="fas fa-calendar me-1"></i>Necesario antes del {{ $request->needed_by_date->format('d/m/Y') }}</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Footer con botones --}}
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('pets.create') }}" class="btn btn-bucaramanga-secondary">
                                        <i class="fas fa-heart me-1"></i>Quiero ayudar
                                    </a>
                                    <small class="text-muted text-center">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Registra tu mascota como donante para poder ayudar
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $activeRequests->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                <h4>¡Excelente noticia!</h4>
                <p class="text-muted">No hay solicitudes urgentes en este momento. Todos los casos han sido atendidos.</p>
                <a href="{{ route('pets.create') }}" class="btn btn-bucaramanga-primary">
                    <i class="fas fa-plus me-1"></i>Registrar mi mascota como donante
                </a>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">
                <strong>Banco de Sangre Canina</strong> - Salvando vidas peludas juntos
                <br><small>Cada donación cuenta, cada vida importa</small>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>