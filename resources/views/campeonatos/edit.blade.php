@extends('layouts.plantilla')
@section('titulo', 'Nuevo campeonato')
@section('contenido')

<h1 class="text-center my-4">Editar campeonato  {{$campeonato->nombre}}</h1>
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
    <form action="{{ route('campeonatos.update',$campeonato) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @method('put')
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del campeonato: *</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{$campeonato->nombre}}" required>
            <div class="invalid-feedback">
                Por favor, ingrese el nombre del campeonato.
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion: *</label>
            <textarea id="descripcion" name="descripcion" class="form-control" required>{{$campeonato->descripcion}}</textarea>
            <div class="invalid-feedback">
                Por favor, seleccione una descripcion.
            </div>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha: *</label>
            <input type="date" id="fecha" name="fecha" class="form-control" value="{{$campeonato->fecha}}" required>
            <div class="invalid-feedback">
                Por favor, seleccione una fecha.
            </div>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imágen:</label>
            <input type="file" id="imagen" name="imagen" class="form-control">
        </div>

        <div class="col-sm-12">
            <label for="carreras" class="form-label">Carreras:</label>
            <select name="carreras[]" id="carreras" class="form-control" multiple="multiple" required>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ in_array($carrera->id, old('carreras', $carrerasSeleccionadas)) ? 'selected' : '' }}>{{ $carrera->nombre }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione al menos una carrera.
            </div>
        </div>

            <div class="d-grid my-5">
                <button type="submit" class="btn btn-primary btn-block">Editar</button>
            </div>

    </form>
</div>

<script>
    $(document).ready(function() {
        $('#carreras').select2();
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
