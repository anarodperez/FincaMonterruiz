<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Nombre del Sitio</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('imagenes/favicon.ico') }}" type="image/png">

    <!-- Fuente de Google -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!-- Estilos personalizados y de la barra de navegación -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    @yield('css')

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/56ace10afe.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Contenido Principal -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap Bundle incluye Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

    <!-- Scripts Personalizados -->
    @stack('scripts')
</body>

</html>
