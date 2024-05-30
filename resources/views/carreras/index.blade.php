@extends('layouts.plantilla')
@section('titulo', 'Listado de Carreras')
@section('contenido')
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <style>
        #carrerasTable_filter label{
            display: none;
        }
        .dataTables_filter {
            float: right;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .alert {
            margin-top: 20px;
        }
        .search-create-wrapper {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }
        .search-input {
            width: 200px;
        }
    </style>
</head>

<div class="container mx-auto p-4">
    <h1 class="text-4xl font-bold mb-4">Listado de Carreras</h1>
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
    <hr>
    @if (count($carreras) > 0)
    <div class="table-responsive">
        <div class="search-create-wrapper mb-3">
            <a class="btn button-create" role="button" href="{{ route('carreras.create') }}">
                <i class="fas fa-plus"></i> Crear carrera
            </a>
            <input type="search" class="form-control search-input" placeholder="Buscar..." id="searchInput">
        </div>
        <table id="carrerasTable" class="table table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="px-4 py-2">Nombre</th>
                    <th scope="col" class="px-4 py-2">Vueltas</th>
                    <th scope="col" class="px-4 py-2">Fecha</th>
                    <th scope="col" class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carreras as $carrera)
                <tr>
                    <td>{{ $carrera->nombre }}</td>
                    <td>{{ $carrera->vueltas }}</td>
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
    </div>
    @else
    <p class="text-center">No existen carreras</p>
    @endif
</div>

<script>
    $(document).ready(function() {
        var table = $('#carrerasTable').DataTable();
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

    });
</script>
@endsection
