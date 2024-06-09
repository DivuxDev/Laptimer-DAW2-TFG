@extends('layouts.plantilla')
@section('titulo', 'tienda')
@section('contenido')
<div class="container mt-5">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .card-body:hover{
            x-scale: 1.1;
        }
        .banner {
            background: var(--primary-color-1);
            color: white;
            padding: 50px 0;
            text-align: center;
            position: relative;
        }
        .banner h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .banner .line {
            width: 50px;
            height: 4px;
            background: white;
            margin: 0 auto 30px;
        }
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .feature {
            text-align: center;
            max-width: 150px;
        }
        .feature i {
            font-size: 2em;
            margin-bottom: 10px;
        }
    </style>
    <h1 class="text-center">Nuestros productos</h1>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-6">
                <img src="https://via.placeholder.com/600x700" alt="Product Image" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2>DPT Laptimer V1.0</h2>
                <h4>95.00€</h4>
                <p>¡Presentamos el Laptimer DPT V1, el cronómetro definitivo para todos los entusiastas de las carreras! Diseñado para ofrecer precisión, facilidad de uso y robustez, el Laptimer DPT V1 es el compañero perfecto para tus competencias de velocidad, ya sea en una pista profesional o en una carrera de aficionados.</p>
                <div class="input-group mb-3" style="max-width: 300px;">
                    <input type="number" class="form-control" value="1">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-cart"></i> Añadir al carrito
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="banner">
    <h1>CARACTERÍSTICAS DEL PRODUCTO</h1>
    <div class="line"></div>
    <div class="features">
        <div class="feature">
            <i class="fas fa-th"></i>
            <p>Perfecto para uso doméstico</p>
        </div>
        <div class="feature">
            <i class="fas fa-compress"></i>
            <p>Administración y tamaño reducidos</p>
        </div>
        <div class="feature">
            <i class="fas fa-cogs"></i>
            <p>Fácil Configuración</p>
        </div>
        <div class="feature">
            <i class="fas fa-hammer"></i>
            <p>Construcción 100% artesanal</p>
        </div>
        <div class="feature">
            <i class="fas fa-handshake"></i>
            <p>Soporte personalizado</p>
        </div>
    </div>
</div>
@endsection
