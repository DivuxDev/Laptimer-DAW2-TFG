@extends('layouts.plantilla')
@section('titulo', 'Listado de Coches')
@section('contenido')
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <style>
        #cochesTable_filter label{
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

<div class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-4xl font-bold mb-4">Listado de Coches</h1>
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
        @if (count($coches) > 0)
        <div class="table-responsive">
            <div class="search-create-wrapper mb-3">
                <a class="btn button-create" role="button" href="{{ route('coches.create') }}">
                    <i class="fas fa-plus"></i> Crear coche
                </a>
                <input type="search" class="form-control search-input" placeholder="Buscar..." id="searchInput">
            </div>
            <table id="cochesTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-2">Modelo</th>
                        <th scope="col" class="px-4 py-2">Categoría</th>
                        <th scope="col" class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coches as $coche)
                    <tr>
                        <td>{{ $coche->modelo }}</td>
                        <td>{{ $coche->categoria ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-sm button-read text-white" role="button" href="{{ route('coches.show', $coche) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm button-update text-white" role="button" href="{{ route('coches.edit', $coche) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('coches.destroy', $coche) }}" method="POST" id="formBorrar">
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
        <p class="text-center">No existen coches</p>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#cochesTable').DataTable({
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
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</div>
@endsection
