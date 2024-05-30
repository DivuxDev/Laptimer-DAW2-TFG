@extends('layouts.plantilla')

@section('titulo', 'Detalle de Coche')

@section('contenido')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #dc3545;
            color: white;
        }
        .card-body img {
            max-width: 100%;
            height: auto;
        }
        .content-section {
            margin-top: 20px;
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
    @endif

    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="text-3xl font-bold">{{ $coche->modelo }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    Imagen
                </div>
                <div class="card-body text-center">
                    @if ($coche->imagen_id)
                        <img src="{{ asset('ruta/a/imagen/' . $coche->imagen_id) }}" alt="Imagen del coche">
                    @else
                        <p>No hay imagen disponible.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    Jugadores asignados
                </div>
                <div class="card-body">
                    @forelse ($coche->jugadores as $jugador)
                        <p>{{ $jugador->nombre }}</p>
                    @empty
                        <p>No tiene ningún jugador asociado.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    Categoría
                </div>
                <div class="card-body">
                    <p>{{ $coche->categoria }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
