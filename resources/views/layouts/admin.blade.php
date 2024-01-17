<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    {{-- Alpine --}}

    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- CSS -->
    @yield('css')

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/56ace10afe.js" crossorigin="anonymous"></script>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        /* Estilo adicional para ocultar el menú */
        #sidebar.collapsed {
            display: none;
        }
    </style>

    <!-- Scripts -->
    <script>
        function cambiar(el, id) {
            el.preventDefault();
            const oculto = document.getElementById('oculto');
            oculto.setAttribute('value', id);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    {{-- Navbar --}}
    @include('layouts.navbar')

    <div class="container-fluid" style=" min-height: 600px; ">
        <div class="row">
            {{-- Incluir la barra lateral --}}
            @include('layouts.sidebar', ['class' => 'col-md-4 col-lg-3'])

            {{-- Contenido principal --}}
            <main role="main" class="col-md-8 ml-sm-auto col-lg-10 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Footer --}}
    @include('layouts.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
