{{-- resources/views/public/pet-active-requests.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes para {{ $pet->name }} - Banco de Sangre Canina</title>
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
            padding: 40px 0;
            position: relative;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 70% 30%, rgba(248, 220, 11, 0.15) 0%, transparent 50%);
        }
        .pet-info {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-top: -30px;
            position: relative;
            z-index: 10;
        }
        .urgency-badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .urgency-alta { background-color: #e74c3c; color: white; }
        .urgency-media { background-color: #f39c12; color: white; }
        .urgency-baja { background-color: #27ae60; color: white; }
        .request-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid var(--bucaramanga-blue-primary);
        }
        .request-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .request-card.urgency-alta { border-left-color: #e74c3c; }
        .request-card.urgency-media { border-left-color: #f39c12; }
        .request-card.urgency-baja { border-left-color: #27ae60; }

        /* Botones con colores institucionales */
        .btn-bucaramanga-primary {
            background: linear-gradient(135deg, var(--bucaramanga-green) 0%, var(--bucaramanga-green-light) 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(5, 150, 105, 0.3);
        }
        .btn-bucaramanga-primary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-green-dark) 0%, var(--bucaramanga-green) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(5, 150, 105, 0.4);
            color: white;
        }

        .btn-bucaramanga-secondary {
            background: linear-gradient(135deg, var(--bucaramanga-blue-primary) 0%, var(--bucaramanga-blue-secondary) 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(30, 58, 138, 0.3);
        }
        .btn-bucaramanga-secondary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-blue-light) 0%, var(--bucaramanga-blue-primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(30, 58, 138, 0.4);
            color: white;
        }

        /* Elementos de acento */
        .text-bucaramanga-green { color: var(--bucaramanga-green) !important; }
        .text-bucaramanga-blue { color: var(--bucaramanga-blue-primary) !important; }
        .text-bucaramanga-gold { color: var(--bucaramanga-gold) !important; }
    </style>
</head>
<body class="bg-light">
    {{-- Header Hero --}}
    <div class="hero-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 mx-auto">
                    <h1 class="display-5 mb-3">
                        <i class="fas fa-heart text-light me-3"></i>
                        Casos que {{ $pet->name }} puede ayudar
                    </h1>
                    <p class="lead mb-0">
                        Hemos encontrado <strong>{{ $activeRequests->count() }}</strong> solicitudes activas
                        compatibles con el tipo de sangre de tu mascota.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Información de la mascota --}}
    <div class="container">
        <div class="pet-info">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="text-bucaramanga-green mb-2 fw-bold">
                        <i class="fas fa-dog me-2 text-bucaramanga-gold"></i>{{ $pet->name }}
                    </h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Raza:</strong> {{ $pet->breed }}</p>
                            <p class="mb-1"><strong>Peso:</strong> {{ $pet->weight_kg }}kg</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-1"><strong>Tipo de sangre:</strong>
                                <span class="badge" style="background: linear-gradient(135deg, var(--bucaramanga-blue-primary) 0%, var(--bucaramanga-blue-secondary) 100%); box-shadow: 0 2px 4px rgba(30, 58, 138, 0.3);">{{ $pet->blood_type }}</span>
                            </p>
                            <p class="mb-1"><strong>Tutor:</strong> {{ $pet->tutor->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="bg-light rounded p-3">
                        <i class="fas fa-heartbeat fa-3x text-danger mb-2"></i>
                        <h5 class="text-muted">Donante Registrado</h5>
                        <small class="text-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Aprobado desde {{ $pet->approved_at->format('M Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Navegación --}}
    <div class="container mt-4 mb-4">
        <nav class="d-flex justify-content-between align-items-center">
            <a href="{{ route('public.active-requests') }}" class="btn btn-bucaramanga-primary">
                <i class="fas fa-arrow-left me-1"></i>Ver todas las solicitudes
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="fas fa-home me-1"></i>Inicio
            </a>
        </nav>
    </div>

    {{-- Lista de Solicitudes Compatibles --}}
    <div class="container mb-5">
        @if($activeRequests->count() > 0)
            <div class="row">
                @foreach($activeRequests as $request)
                    <div class="col-lg-6 mb-4">
                        <div class="card request-card urgency-{{ $request->urgency_level }} h-100">
                            {{-- Header de la tarjeta --}}
                            <div class="card-header bg-white border-0 pb-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1">🐕 {{ $request->patient_name }}</h5>
                                        <small class="text-muted">{{ $request->patient_breed }} • {{ $request->patient_weight }}kg</small>
                                    </div>
                                    <span class="urgency-badge urgency-{{ $request->urgency_level }}">
                                        @switch($request->urgency_level)
                                            @case('alta')
                                                🚨 ALTA
                                                @break
                                            @case('media')
                                                ⏰ MEDIA
                                                @break
                                            @default
                                                📅 BAJA
                                        @endswitch
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-info">🩸 {{ $request->blood_type }}</span>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-clock me-1"></i>{{ $request->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            {{-- Cuerpo de la tarjeta --}}
                            <div class="card-body">
                                {{-- Información del veterinario --}}
                                <div class="bg-light p-3 rounded mb-3">
                                    <h6 class="text-bucaramanga-blue mb-2">
                                        <i class="fas fa-user-md me-1"></i>Información del Veterinario
                                    </h6>
                                    <div class="small">
                                        <div><strong>Dr. {{ $request->veterinarian->name ?? 'No especificado' }}</strong></div>
                                        @if($request->veterinarian && $request->veterinarian->clinic_name)
                                            <div class="text-muted">
                                                <i class="fas fa-hospital me-1"></i>{{ $request->veterinarian->clinic_name }}
                                            </div>
                                        @endif
                                        @if($request->veterinarian && $request->veterinarian->clinic_address)
                                            <div class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $request->veterinarian->clinic_address }}
                                            </div>
                                        @endif
                                        @if($request->clinic_contact)
                                            <div class="text-muted">
                                                <i class="fas fa-phone me-1"></i>{{ $request->clinic_contact }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Descripción del caso --}}
                                <div class="mb-3">
                                    <h6 class="text-dark">
                                        <i class="fas fa-notes-medical me-1"></i>Situación Médica
                                    </h6>
                                    <p class="card-text">{{ $request->medical_reason }}</p>
                                </div>

                                {{-- Información adicional --}}
                                @if($request->needed_by_date)
                                    <div class="alert alert-warning py-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <strong>Fecha límite:</strong> {{ $request->needed_by_date->format('d/m/Y H:i') }}
                                        <small class="d-block">{{ $request->needed_by_date->diffForHumans() }}</small>
                                    </div>
                                @endif

                                @if($request->description)
                                    <div class="border-start border-3 border-info ps-3 mb-3">
                                        <small class="text-muted">
                                            <strong>Descripción adicional:</strong><br>
                                            {{ $request->description }}
                                        </small>
                                    </div>
                                @endif
                            </div>

                            {{-- Footer con botones --}}
                            <div class="card-footer bg-transparent border-0">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-bucaramanga-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#helpModal{{ $request->id }}">
                                        <i class="fas fa-heart me-1"></i>{{ $pet->name }} quiere ayudar
                                    </button>
                                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#declineModal{{ $request->id }}">
                                        <i class="fas fa-times me-1"></i>No podemos ayudar ahora
                                    </button>
                                    <small class="text-muted text-center mt-1">
                                        <i class="fas fa-info-circle me-1"></i>
                                        El veterinario recibirá tus datos de contacto para coordinar la donación
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal para ayudar --}}
                    <div class="modal fade" id="helpModal{{ $request->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header text-white" style="background-color: var(--bucaramanga-green);">
                                    <h5 class="modal-title">
                                        <i class="fas fa-heart me-2"></i>
                                        {{ $pet->name }} ayudará a {{ $request->patient_name }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('public.donation.accept', $request->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                                    <input type="hidden" name="donor_name" value="{{ $pet->tutor->name }}">
                                    <input type="hidden" name="donor_email" value="{{ $pet->tutor->email }}">
                                    <input type="hidden" name="donor_phone" value="{{ $pet->tutor->phone }}">

                                    <div class="modal-body">
                                        <div class="alert alert-success">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>¡Excelente!</strong> El Dr. {{ $request->veterinarian->name ?? 'veterinario' }}
                                            recibirá tus datos de contacto y se comunicará contigo para coordinar la donación.
                                        </div>

                                        {{-- Resumen de la donación --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="bg-light p-3 rounded">
                                                    <h6 class="text-primary mb-2">👤 Datos del Donante</h6>
                                                    <div class="small">
                                                        <div><strong>Tutor:</strong> {{ $pet->tutor->name }}</div>
                                                        <div><strong>Email:</strong> {{ $pet->tutor->email }}</div>
                                                        <div><strong>Teléfono:</strong> {{ $pet->tutor->phone }}</div>
                                                        <div><strong>Mascota:</strong> {{ $pet->name }} ({{ $pet->breed }})</div>
                                                        <div><strong>Peso:</strong> {{ $pet->weight_kg }}kg</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bg-light p-3 rounded">
                                                    <h6 class="text-danger mb-2">🏥 Datos del Caso</h6>
                                                    <div class="small">
                                                        <div><strong>Paciente:</strong> {{ $request->patient_name }}</div>
                                                        <div><strong>Veterinario:</strong> Dr. {{ $request->veterinarian->name ?? 'No especificado' }}</div>
                                                        <div><strong>Urgencia:</strong> {{ strtoupper($request->urgency_level) }}</div>
                                                        <div><strong>Tipo compatible:</strong> {{ $request->blood_type }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label class="form-label">Mensaje para el veterinario (opcional)</label>
                                            <textarea name="message" class="form-control" rows="3"
                                                placeholder="Ej: {{ $pet->name }} está disponible mañana en la mañana. Podemos ir a la clínica después de las 2:00 PM..."></textarea>
                                        </div>

                                        <div class="mt-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="confirm{{ $request->id }}" required>
                                                <label class="form-check-label" for="confirm{{ $request->id }}">
                                                    Confirmo que {{ $pet->name }} está en buen estado de salud y disponible para donar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-bucaramanga-secondary btn-lg">
                                            <i class="fas fa-paper-plane me-1"></i>Confirmar Donación
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal para declinar --}}
                    <div class="modal fade" id="declineModal{{ $request->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $pet->name }} no puede ayudar ahora</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('public.donation.decline', $request->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">
                                    <div class="modal-body">
                                        <p>Entendemos que no siempre es posible ayudar. ¿Cuál es el motivo?</p>
                                        <div class="mb-3">
                                            <select name="reason" class="form-select">
                                                <option value="">Selecciona un motivo...</option>
                                                <option value="donacion_reciente">{{ $pet->name }} donó recientemente</option>
                                                <option value="problemas_salud">{{ $pet->name }} tiene problemas de salud temporales</option>
                                                <option value="no_disponible">No estamos disponibles en las fechas necesarias</option>
                                                <option value="viajando">Estamos viajando</option>
                                                <option value="veterinario_lejos">La clínica está muy lejos</option>
                                                <option value="otro">Otro motivo</option>
                                            </select>
                                        </div>
                                        <div class="alert alert-info">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Esta información nos ayuda a mejorar nuestro servicio y no se compartirá con el veterinario.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-bucaramanga-primary">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-white rounded-3 p-5 shadow-sm">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4>No hay casos compatibles en este momento</h4>
                    <p class="text-muted mb-4">
                        No encontramos solicitudes activas que necesiten el tipo de sangre de {{ $pet->name }}
                        ({{ $pet->blood_type }}) en este momento.
                    </p>
                    <div class="row text-center">
                        <div class="col-md-6">
                            <a href="{{ route('public.active-requests') }}" class="btn btn-bucaramanga-primary">
                                <i class="fas fa-list me-1"></i>Ver todas las solicitudes
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-home me-1"></i>Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-2">
                <strong>{{ $pet->name }}</strong> está registrado en el Banco de Sangre Canina
            </p>
            <small class="text-muted">
                Gracias por ser parte de nuestra comunidad de héroes de cuatro patas
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>