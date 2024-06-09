@extends('layouts.plantilla')
@section('titulo', 'Listado de equipos')
@section('contenido')
<head>
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
    <h1 class="text-4xl font-bold mb-4">Listado de dispositivos</h1>
    @if (count($dispositivos) > 0)
<div class="table-responsive">
    <table id="dispositivosTable" class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col" class="px-4 py-2">Nombre</th>
                <th scope="col" class="px-4 py-2">MAC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dispositivos as $dispositivo)
            <tr>
                <td>{{ $dispositivo->nombre }}</td>
                <td>{{ $dispositivo->mac }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<p class="text-center">No existen dispositivos</p>
@endif
</div>
<script>
    $(document).ready(function() {
        var table = $('#dispositivosTable').DataTable({
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
@endsection
