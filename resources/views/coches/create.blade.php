@extends('layouts.plantilla')
@section('titulo', 'Crear coche')
@section('contenido')
<h1 class="text-center my-4">Nuevo coche</h1>

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
    <form action="{{ route('coches.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo del coche:</label>
            <input type="text" id="modelo" name="modelo" class="form-control" value="{{ old('modelo') }}" required>
            <div class="invalid-feedback">
                Por favor, ingrese el modelo del coche.
            </div>
        </div>

        <div class="mb-3">
            <label for="marca" class="form-label">Marca:</label>
            <input type="text" id="marca" name="marca" class="form-control" value="{{ old('marca') }}" required>
            <div class="invalid-feedback">
                Por favor, ingrese la marca del coche.
            </div>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imágen:</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
        </div>


        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría:</label>
            <input type="text" id="categoria" name="categoria" class="form-control" value="{{ old('categoria') }}" required>
            <div class="invalid-feedback">
                Por favor, ingrese la categoría del coche.
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-block">Crear</button>
        </div>
    </form>
</div>

<script>
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
