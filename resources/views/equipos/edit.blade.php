@extends('layouts.plantilla')
@section('titulo', 'Editar Equipo')
@section('contenido')

<h1 class="text-center my-4">Editar Equipo</h1>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

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

<div class="container">
    <form action="{{ route('equipos.update', $equipo->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del equipo:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $equipo->nombre }}" required>
            <div class="invalid-feedback">
                Por favor, ingrese el nombre del equipo.
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required>{{ $equipo->descripcion }}</textarea>
            <div class="invalid-feedback">
                Por favor, ingrese una descripción.
            </div>
        </div>

        <div class="mb-3">
            <label for="jugadores" class="form-label">Miembros:</label>
            <select name="jugadores[]" id="jugadores" class="form-control" multiple="multiple" required>
                @foreach($jugadores as $jugador)
                    <option value="{{ $jugador->id }}" {{ in_array($jugador->id, $equipo->jugadores->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $jugador->nombre }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione al menos un jugador.
            </div>
        </div>

        <div class="mb-3">
            <label for="imagenes" class="form-label">Imágenes:</label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple>
            <small class="form-text text-muted">Si no desea cambiar las imágenes, deje este campo vacío.</small>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
