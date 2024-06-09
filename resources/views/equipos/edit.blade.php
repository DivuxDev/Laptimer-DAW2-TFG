@extends('layouts.plantilla')
@section('titulo', 'Editar Equipo')
@section('contenido')

<h1 class="text-center my-4">Editar Equipo</h1>

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
    <form action="{{ route('equipos.update', $equipo->slug) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del equipo:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $equipo->nombre) }}" required>
            <div class="invalid-feedback">
                Por favor, ingrese el nombre del equipo.
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $equipo->descripcion) }}</textarea>
            <div class="invalid-feedback">
                Por favor, ingrese una descripción.
            </div>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imágen:</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
        </div>

        <div class="mb-3">
            <label for="miembros" class="form-label">Miembros:</label>
            <select name="miembros[]" id="miembros" class="form-control" multiple="multiple" required>
                @foreach($miembros as $miembro)
                    <option value="{{ $miembro->id }}" {{ in_array($miembro->id, $equipo->jugadores->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $miembro->nombre }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione al menos un miembro.
            </div>
            
        </div>


        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#miembros').select2();
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
