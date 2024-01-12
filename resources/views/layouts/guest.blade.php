<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Finca Monterruiz</title>

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

    <script src="{{ asset('js/cookies.js') }}"></script>
    <style>
       #cookieConsentContainer {
    display: none;
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f1f1f1;
    padding: 20px;
    text-align: center;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000; /* Asegurándose de que esté por encima de otros elementos */
}

#cookieConsentContainer p {
    margin: 0 0 10px 0;
    color: #333; /* Color del texto */
}

#cookieConsentContainer a {
    color: #5c7c64; /* Color personalizado para los enlaces */
    text-decoration: underline;
}

#cookieConsentContainer a:hover {
    color: darken(#5c7c64, 10%); /* Oscurece el color al pasar el mouse */
}

#acceptCookieConsent {
    background-color: #5c7c64; /* Color personalizado para el botón */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#acceptCookieConsent:hover {
    background-color: darken(#5c7c64, 10%); /* Oscurece el color al pasar el mouse */
}


    </style>
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Contenido Principal -->
    <main class="py-4">
        @yield('content')
        <div id="cookieConsentContainer" style="display: none; position: fixed; bottom: 0; width: 100%; background-color: #f1f1f1; padding: 10px; text-align: center;">
            <p>Utilizamos cookies para mejorar su experiencia. Al continuar navegando, acepta nuestro <a href="#">uso de cookies</a>.</p>
            <button id="acceptCookieConsent">Aceptar</button>
        </div>

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
