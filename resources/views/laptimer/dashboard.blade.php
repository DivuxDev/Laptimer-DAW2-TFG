@extends('layouts.plantilla')
@section('titulo', 'Dashboard')
@section('contenido')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <style>
        .calendar {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }
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
        .tag {
            display: inline-block;
            padding: 0.5em 1em;
            border-radius: 20px;
            background-color: #f0f0f0;
            color: #333;
            font-size: 0.875em;
            margin: 0.2em;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .tag:hover {
            background-color: #e0e0e0;
            color: #000;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header">Próximos campeonatos</div>
                        <div class="card-body">
                            @if($proximasCarreras->isEmpty())
                                <p>No hay campeonatos próximos.</p>
                            @else
                                <ul>
                                    @foreach($proximasCarreras as $carrera)
                                        <li class="tag">{{ $carrera->nombre }} - {{ $carrera->fecha }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header">Últimos jugadores</div>
                        <div class="card-body">
                            @if($ultimosJugadores->isEmpty())
                                <p>No hay nuevos jugadores.</p>
                            @else
                                <ul>
                                    @foreach($ultimosJugadores as $jugador)
                                        <li class="tag">{{ $jugador->nombre }} - {{ $jugador->created_at->format('d/m/Y') }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-header">Últimas carreras</div>
                        <div class="card-body">
                            @if($ultimasCarreras->isEmpty())
                                <p>No hay carreras recientes.</p>
                            @else
                                <ul>
                                    @foreach($ultimasCarreras as $carrera)
                                        <li class="tag">{{ $carrera->nombre }} - {{ $carrera->fecha }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-header">Calendario de eventos</div>
                <div class="card-body p-4 border">
                    <div id="calendar" class="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
        $('#calendar').fullCalendar({
            locale: 'es', // Set the locale to Spanish
            events: @json($carreras),
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today:    'Hoy',
                month:    'Mes',
                week:     'Semana',
                day:      'Día'
            },
            allDayText: 'Todo el día',
            eventLimitText: 'más'
        });
    });
</script>
</body>
@endsection
