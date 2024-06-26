@extends('layouts.plantilla')
@section('titulo', 'Detalle carrera')
@section('contenido')
<head>
    
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
            <h1 class="text-3xl font-bold">Detalle de la Carrera: {{ $carrera->nombre }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Jugadores
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="carreraTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Puesto</th>
                                    <th>Dorsal</th>
                                    <th>Jugador</th>
                                    <th>Equipo</th>
                                    <th>Coche</th>
                                    <th>Mejor tiempo</th>
                                    <th>Tiempo total</th>
                                    <th>Tiempo medio</th>
                                    <th>Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                    $participacionesOrdenadas = $carrera->participaciones->sortBy(function($participacion) {
                                        $tiempos = $participacion->tiempos->pluck('tiempo')->map(function($item) {
                                            return (float) $item;
                                        });
                                        return $tiempos->sum();
                                    });
                                @endphp
                                @foreach ($participacionesOrdenadas as $participacion)
                                    @php
                                        $jugador = $participacion->jugador;
                                        $tiempos = $participacion->tiempos->pluck('tiempo')->map(function($item) {
                                            return (float) $item;
                                        });

                                        $totalTiempo = $tiempos->sum();
                                        $mejorTiempo = $tiempos->min();
                                        $tiempoMedio = $tiempos->avg();
                                    @endphp
                                    <tr>
                                        <td>{{ $counter++ }}</td>
                                        <td>#{{ $participacion->jugador->id }}</td>
                                        <td>{{ $participacion->jugador->nombre }}</td>
                                        <td>{{ $participacion->jugador->equipo ? $participacion->jugador->equipo->nombre : 'N/A' }}</td>
                                        <td>{{ $participacion->coche ? $participacion->coche->modelo : 'N/A' }}</td>
                                        <td>{{ number_format($mejorTiempo, 2) }} s</td>
                                        <td>{{ number_format($totalTiempo, 2) }} s</td>
                                        <td>{{ number_format($tiempoMedio, 2) }} s</td>
                                        <td> <a class="btn btn-sm button-read text-white" role="button" href="{{ route('carreras.performance', ['carrera' => $carrera, 'jugador' => $jugador]) }}">
                                            <i class="fas fa-eye"></i>
                                        </a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    Información de la Carrera
                </div>
                <div class="card-body">
                    <p><strong>Dispositivo asociado:</strong> {{ $carrera->dispositivo->nombre ?? 'No disponible' }}</p>
                    <p><strong>En curso:</strong> {{ $carrera->en_curso ? 'Sí' : 'No' }}</p>
                    <p><strong>Vueltas:</strong> {{ $carrera->vueltas ?? 'No disponible' }}</p>
                    <p><strong>Fecha:</strong> {{ $carrera->fecha ?? 'No disponible' }}</p>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    Imagen
                </div>
                <div class="card-body text-center">
                    @if ($carrera->imagen)
                    <a href="#full-image"><img src="{{ asset('storage/' . $carrera->imagen->url) }}" alt="Imagen de la carrera" class="img-fluid"></a>
                    <div id="full-image" class="full-screen-img">
                        <a href="#"><img src="{{ asset('storage/' . $carrera->imagen->url) }}" alt="Imagen de la carrera"></a>
                    </div>
                    @else
                        <p>No hay imagen disponible.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#carreraTable').DataTable({
            "order": [[6, "asc"]],
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ entradas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron resultados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
@endsection
