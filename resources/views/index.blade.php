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
            background: linear-gradient(135deg, #b31217, #e52d27);
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
    <div class="row my-4">
        <!-- Producto 1 -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Producto 1">
                <div class="card-body">
                    <h5 class="card-title">Laptimer DPT V1</h5>
                    <p class="card-text">95.00€</p>
                    <a href="#" class="btn btn-danger">Agregar al carrito</a>
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
