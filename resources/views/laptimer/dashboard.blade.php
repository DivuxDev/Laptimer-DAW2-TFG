@extends('layouts.plantilla')
@section('titulo', 'Dashboard')
@section('contenido')
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <style>
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: var(--primary-color-1);
            color: white;
            font-weight: bold;
        }
        .dropdown-menu {
            right: 0;
            left: auto;
        }
        .calendar {
            width: 20%;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Próximos campeonatos</div>
                <div class="card-body">
                    @if($proximasCarreras->isEmpty())
                        <p>No hay campeonatos próximos.</p>
                    @else
                        <ul>
                            @foreach($proximasCarreras as $carrera)
                                <li>{{ $carrera->nombre }} - {{ $carrera->fecha }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Vueltas rápidas</div>
                <div class="card-body">
                    {{-- @if($vueltasRapidas->isEmpty())
                        <p>No hay vueltas rápidas registradas.</p>
                    @else
                        <ul>
                            @foreach($vueltasRapidas as $vuelta)
                                <li>{{ $vuelta->jugador->nombre }} - {{ $vuelta->tiempo }}s</li>
                            @endforeach
                        </ul>
                    @endif --}}
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Últimos jugadores</div>
                <div class="card-body">
                    @if($ultimosJugadores->isEmpty())
                        <p>No hay nuevos jugadores.</p>
                    @else
                        <ul>
                            @foreach($ultimosJugadores as $jugador)
                                <li>{{ $jugador->nombre }} - {{ $jugador->created_at->format('d/m/Y') }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">Últimas carreras</div>
                <div class="card-body">
                    @if($ultimasCarreras->isEmpty())
                        <p>No hay carreras recientes.</p>
                    @else
                        <ul>
                            @foreach($ultimasCarreras as $carrera)
                                <li>{{ $carrera->nombre }} - {{ $carrera->fecha }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 mb-4">
                <div class="card-header">Calendario de eventos</div>
                <div class="card-body p-4">
                    <div id="calendar"></div>
                </div>
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            events: @json($carreras)
        });
    });
</script>
</body>
@endsection