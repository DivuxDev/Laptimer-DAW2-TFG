@extends('layouts.plantilla')
@section('titulo', 'Nueva Carrera')
@section('contenido')

<h1 class="text-center my-4">Nueva Carrera</h1>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Hubo errores en el formulario:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('carreras.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la carrera: *</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="" required>
            <div class="invalid-feedback">
                Por favor, ingrese el nombre de la carrera.
            </div>
        </div>

        <div class="mb-3">
            <label for="vueltas" class="form-label">Vueltas: *</label>
            <input type="number" min="0" max="999" id="vueltas" name="vueltas" class="form-control" value="" required>
            <div class="invalid-feedback">
                Por favor, ingrese el número de vueltas.
            </div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" id="en_curso" name="en_curso" value="true" class="form-check-input">
            <label for="en_curso" class="form-check-label">En curso</label>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha: *</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="" required>
            <div class="invalid-feedback">
                Por favor, seleccione una fecha.
            </div>
        </div>

        <div class="mb-3">
            <label for="dispositivo_id" class="form-label">Dispositivo: *</label>
            <select name="dispositivo_id" id="dispositivo_id" class="form-select" required>
                @foreach ($dispositivos as $dispositivo)
                    <option value="{{ $dispositivo->id }}">{{ $dispositivo->nombre }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione un dispositivo.
            </div>
        </div>

        <div class="mb-3">
            <label for="jugadores" class="form-label">Selecciona los participantes:</label>
            <select name="jugadores[]" id="jugadores" class="form-control" multiple="multiple">
                @foreach($jugadores as $jugador)
                    <option value="{{ $jugador->id }}">{{ $jugador->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imágen:</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Crear</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#jugadores').select2();
    });

    // Bootstrap form validation
    (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
