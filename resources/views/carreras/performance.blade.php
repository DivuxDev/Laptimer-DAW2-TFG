@extends('layouts.plantilla')

@section('titulo', 'Rendimiento del Jugador')

@section('contenido')
<div class="container my-4">
    <h1 class="text-center mb-4">Rendimiento de {{ $jugador->nombre }} en {{ $carrera->nombre }}</h1>

    <div class="row">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Detalle de la Carrera</h5>
                </div>
                <div class="card-body">
                    <p><strong>Carrera:</strong> {{ $carrera->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $carrera->fecha }}</p>
                    <p><strong>Vueltas Totales:</strong> {{ $carrera->vueltas }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Detalle del Jugador</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $jugador->nombre }}</p>
                    <p><strong>Equipo:</strong> {{ $participacion->equipo->nombre ?? 'N/A' }}</p>
                    <p><strong>Coche:</strong> {{ $participacion->coche->modelo ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Estadísticas de Rendimiento</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tiempo Total:</strong> {{ number_format($totalTime, 2) }} s</p>
                    <p><strong>Tiempo Promedio por Vuelta:</strong> {{ number_format($averageTime, 2) }} s</p>
                    <p><strong>Mejor Tiempo:</strong> {{ number_format($bestTime, 2) }} s</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white">
                    <h5 class="card-title mb-0">Gráfico de Rendimiento</h5>
                </div>
                <div class="card-body">
                    <canvas id="lapTimesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('lapTimesChart').getContext('2d');
        var lapTimesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($laps),
                datasets: [{
                    label: 'Tiempo por Vuelta (s)',
                    data: @json($times),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Vuelta'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Tiempo (s)'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
