<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="{{ asset('imagenes/favicon.ico') }}" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
   <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->

    @yield('css')

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/56ace10afe.js" crossorigin="anonymous"></script>
</head>
<body>
    {{-- Navbar --}}
    @include('layouts.navbar')
<main>
    @yield('content')
</main>

<!-- Footer -->
@include('layouts.footer')
<!-- JS Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>



</body>
</html>
