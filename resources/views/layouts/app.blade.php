<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Banco de Sangre Canina')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Variables de color basadas en identidad Bucaramanga */
        :root {
            --bucaramanga-green: #228B22;
            --bucaramanga-green-light: #32CD32;
            --bucaramanga-green-dark: #006400;
            --bucaramanga-blue: #0066CC;
            --bucaramanga-blue-light: #4A90E2;
            --bucaramanga-gray: #6C757D;
            --bucaramanga-gray-light: #F8F9FA;
        }

        /* Hero section con gradiente institucional */
        .hero-section {
            background: linear-gradient(135deg, var(--bucaramanga-green) 0%, var(--bucaramanga-blue) 100%);
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
            background-color: var(--bucaramanga-green);
            border-color: var(--bucaramanga-green);
            color: white;
        }
        .btn-bucaramanga-primary:hover {
            background-color: var(--bucaramanga-green-dark);
            border-color: var(--bucaramanga-green-dark);
            color: white;
        }

        .btn-bucaramanga-secondary {
            background-color: var(--bucaramanga-blue);
            border-color: var(--bucaramanga-blue);
            color: white;
        }
        .btn-bucaramanga-secondary:hover {
            background-color: #0052A3;
            border-color: #0052A3;
            color: white;
        }

        /* Elementos de acento */
        .text-bucaramanga-green { color: var(--bucaramanga-green) !important; }
        .text-bucaramanga-blue { color: var(--bucaramanga-blue) !important; }
        .bg-bucaramanga-green { background-color: var(--bucaramanga-green) !important; }
        .bg-bucaramanga-blue { background-color: var(--bucaramanga-blue) !important; }

        /* Navbar personalizada */
        .navbar-bucaramanga {
            background: linear-gradient(90deg, var(--bucaramanga-green) 0%, var(--bucaramanga-blue) 100%);
        }

        /* Estilo limpio y profesional para formularios */
        .form-control:focus {
            border-color: var(--bucaramanga-green);
            box-shadow: 0 0 0 0.2rem rgba(34, 139, 34, 0.25);
        }

        /* Estadísticas con colores institucionales */
        .stats-card {
            border-left: 4px solid var(--bucaramanga-green);
        }

        /* Footer institucional */
        .footer-bucaramanga {
            background-color: var(--bucaramanga-gray);
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-bucaramanga">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-heart text-danger"></i> Banco de Sangre Canina
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

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-heart text-danger"></i> Banco de Sangre Canina</h5>
                    <p class="mb-0">Salvando vidas peludas juntos</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 Todos los derechos reservados</p>
                    <small class="text-muted">Desarrollado con ❤️ para nuestros amigos de cuatro patas</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>