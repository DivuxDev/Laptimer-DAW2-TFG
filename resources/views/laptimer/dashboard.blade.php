@extends('layouts.plantilla')
@section('titulo', 'Dashboard')
@section('contenido')
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #b31217;
            color: white;
            font-weight: bold;
        }
        .dropdown-menu {
            right: 0;
            left: auto;
        }
        .calendar {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Próximos campeonatos</div>
                <div class="card-body">Contenido aquí</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Vueltas rápidas</div>
                <div class="card-body">Contenido aquí</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Últimos jugadores</div>
                <div class="card-body">Contenido aquí</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Últimas carreras</div>
                <div class="card-body">Contenido aquí</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="calendar card">
                <div class="card-header">Calendario de eventos</div>
                <div class="card-body p-0">
                    <iframe src="https://calendar.google.com/calendar/embed?src=es.spain%23holiday%40group.v.calendar.google.com&ctz=Europe%2FMadrid" style="border: 0" width="100%" height="300" frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
@endsection