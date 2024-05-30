@extends('layouts.plantilla')
@section('titulo', 'Detalle jugador')
@section('contenido')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #dc3545;
            color: white;
        }
        .content-section {
            margin-top: 20px;
        }
        .card-body img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<div class="container mx-auto p-4">
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ session('error') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Confirmación:</strong> {{ session('success') }}.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="text-3xl font-bold">Detalle del Jugador: {{ $jugador->nombre }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Imagen
                </div>
                <div class="card-body text-center">
                    @if ($jugador->imagen)
                        <img src="{{ asset('storage/' . $jugador->imagen) }}" alt="Imagen del jugador" class="img-fluid">
                    @else
                        <p>No hay imagen disponible.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Información del Jugador
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $jugador->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $jugador->fecha ?? 'No disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Equipo
                </div>
                <div class="card-body">
                    @if ($jugador->equipo)
                        <p>{{ $jugador->equipo->nombre }}</p>
                    @else
                        <p>No hay equipo disponible.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Coche
                </div>
                <div class="card-body">
                    @if ($jugador->coche)
                        <p>{{ $jugador->coche->marca }} - {{ $jugador->coche->modelo }}</p>
                    @else
                        <p>No hay coche disponible.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Carreras
                </div>
                <div class="card-body">
                    @if ($jugador->participaciones && $jugador->participaciones->count() > 0)
                        <ul>
                            @foreach ($jugador->participaciones as $participacion)
                                <li>{{ $participacion->carrera->nombre }} - {{ $participacion->carrera->fecha }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No hay carreras disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
