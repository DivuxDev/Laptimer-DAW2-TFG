<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar{
            background-color: var(--primary-color-1) !important;
            color: white;
        }
        .nav-link{
            color: white;
        }
        .nav-item{
            border: 1px solid white;
            border-radius: 5px
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom px-2">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" height="50"> <span  class="font-weight-bold text-white"> DPT</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{route('index')}}">Tienda</a>
                    </li>
                    @if ( Auth::user())           
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{route('laptimer.dashboard')}}">Dashboard</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{route('carreras.list')}}">Campeonatos y Carreras</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{route('jugadores.index')}}">Jugadores</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{route('coches.index')}}">Coches</a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="{{route('equipos.index')}}">Equipos</a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav ml-auto">
                    <!-- Usuario actualmente logeado -->
                    <li class="nav-item dropdown" style="border: 1px solid #ffffff; border-radius: 5px;">
                        @if ( Auth::user())      
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="{{route('dispositivos.index')}}">Dispositivos</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar sesión
                            </a></li>
                        </ul>
                        @else
                        <a class="nav-link" href="{{ route('login') }}" role="button" aria-expanded="false">
                            Iniciar Sesion <i class="fas fa-user-circle"></i>
                        </a>
                        @endif
                    </li>
                </ul>
                <!-- Formulario de logout oculto -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
            </div>
       
    </nav>

    <!-- Bootstrap JS and dependencies (Popper.js and jQuery) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
