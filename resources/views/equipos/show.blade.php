@extends('layouts.plantilla')
@section('titulo', 'Detalle de Equipo')
@section('contenido')
<head>
    <style>
        .equipo-detalle {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .equipo-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .equipo-seccion {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1000px;
            margin-bottom: 20px;
        }
        .equipo-descripcion, .equipo-miembros, .equipo-imagenes {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 48%;
        }
        .equipo-miembros, .equipo-imagenes {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .equipo-miembros h2, .equipo-imagenes h2 {
            margin-bottom: 20px;
        }

    </style>
</head>

<div class="equipo-detalle container mx-auto p-4">
    <div class="equipo-header">
        <h1 class="text-4xl font-bold mb-4">{{ $equipo->nombre }}</h1>
    </div>
    <div class="equipo-seccion">
        <div class="equipo-descripcion">
            <h2>Descripción</h2>
            <p>{{ $equipo->descripcion }}</p>
        </div>
    </div>
    <div class="equipo-seccion">
        <div class="equipo-miembros">
            <h2>Miembros</h2>
            <ul>
                @foreach ($equipo->jugadores as $miembro)
                <li>{{ $miembro->nombre }}</li>
                @endforeach
            </ul>
        </div>
        <div class="equipo-imagenes">
            <h2>Carrousel de Imágenes</h2>
                    <div class="card-body text-center">
                        @if ($equipo->imagen)
                            <img src="{{ asset('storage/' . $equipo->imagen) }}" alt="Imagen del equipo" class="img-fluid">
                        @else
                            <p>No hay imagen disponible.</p>
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
