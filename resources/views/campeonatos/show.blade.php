@extends('layouts.plantilla')
@section('titulo', 'Detalle del Campeonato')
@section('contenido')
<head>
    <style>
        
        .img-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .img-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            <h1 class="text-3xl font-bold">Detalle del Campeonato: {{ $campeonato->nombre }}</h1>
        </div>
    </div>

    <div class="row content-section">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    Descripción
                </div>
                <div class="card-body">
                    {{ $campeonato->descripcion }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    Estado
                </div>
                <div class="card-body">
                    {{ $campeonato->en_curso ? 'En curso' : 'Finalizado' }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    Carreras asociadas al campeonato
                </div>
                <div class="card-body">
                    @if($campeonato->carreras->isEmpty())
                        <p>No hay carreras en este campeonato.</p>
                    @else
                        <table id="carrerasTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($campeonato->carreras as $carrera)
                                    <tr>
                                        <td>{{ $carrera->nombre }}</td>
                                        <td>{{ $carrera->fecha }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a class="btn btn-sm button-read text-white" role="button" href="{{ route('carreras.show', $carrera) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm button-update text-white" role="button" href="{{ route('carreras.edit', $carrera) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('carreras.destroy', $carrera) }}" method="POST" id="formBorrar">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-sm button-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    Imagen
                </div>
                <div class="card-body">
                    @if ($campeonato->imagen)
                    <a href="#full-image"><img src="{{ asset('storage/' . $campeonato->imagen->url) }}" alt="Imagen del campeonato" class="img-fluid"></a>
                    <div id="full-image" class="full-screen-img">
                        <a href="#"><img src="{{  asset('storage/' . $campeonato->imagen->url) }}" alt="Imagen del campeonato"></a>
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
        $('#carrerasTable').DataTable( {
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
