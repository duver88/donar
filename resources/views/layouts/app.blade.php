<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Banco de Sangre Canina')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Tipografías oficiales de Bucaramanga -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables de color OFICIALES de Bucaramanga */
        :root {
            /* Verde institucional principal */
            --bucaramanga-verde-principal: #43883D;  /* Pantone 348C */
            --bucaramanga-verde-claro: #51AD32;     /* Pantone 361C */
            --bucaramanga-verde-palido: #B4D2AF;   /* Pantone 344C */
            --bucaramanga-verde-suave: #C6DEAF;    /* Pantone 579C */

            /* Verdes complementarios */
            --bucaramanga-verde-lima-1: #C7D300;   /* Pantone 382C */
            --bucaramanga-verde-lima-2: #93C01F;   /* Pantone 376C */
            --bucaramanga-verde-oscuro-1: #3F8827; /* Pantone 363C */
            --bucaramanga-verde-oscuro-2: #285F19; /* Pantone 364C */

            /* Amarillo institucional */
            --bucaramanga-amarillo: #F8DC0B;       /* Pantone 108C */
            --bucaramanga-amarillo-claro: #FCF2B1; /* Pantone Yellow 0131 */

            /* Rojo institucional */
            --bucaramanga-rojo: #C20E1A;           /* Pantone 485C */
            --bucaramanga-rosa: #F0A9AA;           /* Pantone 700C */

            /* Grises institucionales */
            --bucaramanga-gris-1: #D9D9D9;
            --bucaramanga-gris-2: #C6C6C5;
            --bucaramanga-gris-3: #B1B1B1;
            --bucaramanga-gris-4: #9C9B9B;
            --bucaramanga-negro: #000000;
        }

        /* Hero section con gradiente institucional */
        .hero-section {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
        }

        /* Overlay sutil para mejor legibilidad */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .hero-section .container {
            position: relative;
            z-index: 2;
        }

        /* Cards con estilo institucional */
        .card-hover {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Navbar con colores institucionales */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Botones con colores institucionales */
        .btn-bucaramanga-primary {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            border: none;
            color: white;
            font-weight: 500;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(67, 136, 61, 0.3);
        }
        .btn-bucaramanga-primary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-verde-oscuro-1) 0%, var(--bucaramanga-verde-principal) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 136, 61, 0.4);
            color: white;
        }

        .btn-bucaramanga-secondary {
            background: linear-gradient(135deg, var(--bucaramanga-amarillo) 0%, var(--bucaramanga-verde-lima-1) 100%);
            border: none;
            color: var(--bucaramanga-verde-oscuro-1);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }
        .btn-bucaramanga-secondary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-verde-lima-1) 0%, var(--bucaramanga-amarillo) 100%);
            transform: translateY(-2px);
            color: var(--bucaramanga-verde-oscuro-1);
        }

        /* Elementos de acento */
        .text-bucaramanga-verde { color: var(--bucaramanga-verde-principal) !important; }
        .text-bucaramanga-amarillo { color: var(--bucaramanga-amarillo) !important; }
        .text-bucaramanga-rojo { color: var(--bucaramanga-rojo) !important; }
        .bg-bucaramanga-verde { background-color: var(--bucaramanga-verde-principal) !important; }
        .bg-bucaramanga-amarillo { background-color: var(--bucaramanga-amarillo) !important; }
        .bg-bucaramanga-principal {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%) !important;
            color: white !important;
        }
        .bg-bucaramanga-acento {
            background: linear-gradient(135deg, var(--bucaramanga-amarillo) 0%, var(--bucaramanga-verde-lima-1) 100%) !important;
            color: var(--bucaramanga-verde-oscuro-1) !important;
        }

        /* Navbar personalizada */
        .navbar-bucaramanga {
            background: linear-gradient(90deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--bucaramanga-amarillo) !important;
            transform: translateY(-1px);
        }

        /* Estilo limpio y profesional para formularios */
        .form-control:focus {
            border-color: var(--bucaramanga-verde-principal);
            box-shadow: 0 0 0 0.2rem rgba(67, 136, 61, 0.25);
        }

        .form-select:focus {
            border-color: var(--bucaramanga-verde-principal);
            box-shadow: 0 0 0 0.2rem rgba(67, 136, 61, 0.25);
        }

        /* Estadísticas con colores institucionales */
        .stats-card {
            border-left: 4px solid var(--bucaramanga-verde-principal);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Footer institucional */
        .footer-bucaramanga {
            background: linear-gradient(135deg, var(--bucaramanga-verde-oscuro-1) 0%, var(--bucaramanga-verde-principal) 100%);
            color: white;
        }

        /* Bootstrap overrides con colores institucionales */
        .btn-primary {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            border: none;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--bucaramanga-verde-oscuro-1) 0%, var(--bucaramanga-verde-principal) 100%);
            transform: translateY(-1px);
        }

        .btn-success {
            background-color: var(--bucaramanga-verde-claro);
            border-color: var(--bucaramanga-verde-claro);
        }

        .btn-warning {
            background-color: var(--bucaramanga-amarillo);
            border-color: var(--bucaramanga-amarillo);
            color: var(--bucaramanga-verde-oscuro-1);
            font-weight: 600;
        }

        .btn-danger {
            background-color: var(--bucaramanga-rojo);
            border-color: var(--bucaramanga-rojo);
        }

        .text-primary { color: var(--bucaramanga-verde-principal) !important; }
        .text-success { color: var(--bucaramanga-verde-claro) !important; }
        .text-warning { color: var(--bucaramanga-amarillo) !important; }
        .text-danger { color: var(--bucaramanga-rojo) !important; }

        .bg-primary { background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%) !important; }
        .bg-success { background-color: var(--bucaramanga-verde-claro) !important; }
        .bg-warning { background-color: var(--bucaramanga-amarillo) !important; }
        .bg-danger { background-color: var(--bucaramanga-rojo) !important; }

        /* Cards institucionales */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
            border-bottom: none;
            font-weight: 600;
        }

        /* Tables */
        .table thead th {
            background: linear-gradient(135deg, var(--bucaramanga-verde-principal) 0%, var(--bucaramanga-verde-claro) 100%);
            color: white;
            border: none;
            font-weight: 500;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(67, 136, 61, 0.05);
        }

        .table-hover > tbody > tr:hover > td {
            background-color: rgba(67, 136, 61, 0.1);
        }

        /* Badges */
        .badge {
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }

        /* Alerts */
        .alert-success {
            background-color: rgba(81, 173, 50, 0.1);
            border-color: var(--bucaramanga-verde-claro);
            color: var(--bucaramanga-verde-oscuro-1);
        }

        .alert-warning {
            background-color: rgba(248, 220, 11, 0.1);
            border-color: var(--bucaramanga-amarillo);
            color: var(--bucaramanga-verde-oscuro-1);
        }

        .alert-danger {
            background-color: rgba(194, 14, 26, 0.1);
            border-color: var(--bucaramanga-rojo);
            color: var(--bucaramanga-rojo);
        }

        /* Tipografías oficiales según manual de identidad */
        body {
            font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif !important;
            font-weight: 400;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: 'Oswald', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif !important;
            font-weight: 500;
            color: var(--bucaramanga-verde-oscuro-1);
        }

        .navbar-brand {
            font-family: 'Oswald', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif !important;
            font-weight: 600;
        }

        .btn {
            font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif !important;
        }

        .card-header {
            font-family: 'Oswald', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-bucaramanga">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/10/Dognar-Logo-04.png" alt="Dognar Logo" style="height: 50px; background: white; border-radius: 10px; padding: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        <a class="nav-link" href="{{ route('veterinarian.register') }}">Registro Veterinario</a>
                    @else
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->role === 'super_admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                    </a></li>
                                @elseif(Auth::user()->role === 'veterinarian')
                                    <li><a class="dropdown-item" href="{{ route('veterinarian.dashboard') }}">
                                        <i class="fas fa-user-md"></i> Dashboard Veterinario
                                    </a></li>
                                @elseif(Auth::user()->role === 'tutor')
                                    <li><a class="dropdown-item" href="{{ route('tutor.dashboard') }}">
                                        <i class="fas fa-dog"></i> Mi Dashboard
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                <div class="container">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                <div class="container">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer-bucaramanga py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                    <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/10/Dognar-Logo-03.png" alt="Dognar Logo" style="height: 80px; margin-bottom: 15px;" class="d-block mx-auto mx-md-0">
                    <p class="mb-2 fw-light">Salvando vidas peludas juntos</p>
                    <div class="d-flex justify-content-center justify-content-md-start gap-3 mt-3">
                        <a href="#" class="text-white" style="font-size: 1.5rem; transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-white" style="font-size: 1.5rem; transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white" style="font-size: 1.5rem; transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <h5 class="text-white mb-3" style="font-family: 'Oswald', sans-serif;">Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-white text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'"><i class="fas fa-angle-right me-2"></i>Inicio</a></li>
                        <li class="mb-2"><a href="{{ route('public.active-requests') }}" class="text-white text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'"><i class="fas fa-angle-right me-2"></i>Solicitudes Activas</a></li>
                        <li class="mb-2"><a href="{{ route('pets.create') }}" class="text-white text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'"><i class="fas fa-angle-right me-2"></i>Registrar Mascota</a></li>
                        <li class="mb-2"><a href="{{ route('veterinarian.register') }}" class="text-white text-decoration-none" style="transition: color 0.3s;" onmouseover="this.style.color='#F8DC0B'" onmouseout="this.style.color='white'"><i class="fas fa-angle-right me-2"></i>Registro Veterinario</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <h5 class="text-white mb-3" style="font-family: 'Oswald', sans-serif;">Contacto</h5>
                    <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>Bucaramanga, Santander</p>
                    <p class="mb-2"><i class="fas fa-envelope me-2"></i>info@dognar.gov.co</p>
                    <p class="mb-0"><i class="fas fa-phone me-2"></i>+57 (7) 123 4567</p>
                    <img src="https://www.bucaramanga.gov.co/wp-content/uploads/2025/06/escudo-alcaldia.png" alt="Escudo Bucaramanga" style="height: 60px; margin-top: 20px;">
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-1">&copy; 2024-2025 Dognar - Alcaldía de Bucaramanga. Todos los derechos reservados.</p>
                    <small style="opacity: 0.8;">Desarrollado con <i class="fas fa-heart" style="color: #C20E1A;"></i> para nuestros amigos de cuatro patas</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>