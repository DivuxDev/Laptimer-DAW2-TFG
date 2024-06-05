<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>@yield('titulo')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    
</head>
<nav>
    @include('layouts.partials.nav')
</nav>
<style>

</style>
<body>

    <main>
        @yield('contenido')
    </main>
    
</body>
<footer style="margin-top: 50px">
    @include('layouts.partials.footer')
</footer>

</html>
