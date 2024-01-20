<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            text-align: center;
        }
        .header {
            background-color: #5c7c64;
            color: white;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .logo-and-name {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .logo-and-name img {
            max-height: 50px;
            margin-right: 10px;
        }

        .content {
            margin-top: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #666666;
        }

        .footer a {
            color: #5c7c64;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- <div class="logo-and-name">
                <img src="https://tudominio.com/img/logo.png" alt="Logo de Finca Monterruiz">
                <h2>Finca Monterruiz</h2>
            </div> --}}
            <h1>Boletín Informativo</h1>
        </div>

        <div class="content">
            <h2>Hola,</h2>
            <p>Gracias por suscribirte a nuestro boletín informativo. Aquí tienes las últimas novedades y ofertas especiales:</p>
            <p>Este es el contenido de tu boletín. Puedes incluir noticias, actualizaciones, ofertas, enlaces y mucho más.</p>

            <!-- Contenido del boletín -->
            <p>Este es el contenido de tu boletín. Puedes incluir noticias, actualizaciones, ofertas, enlaces y mucho más.</p>

            <!-- Agrega más contenido según sea necesario -->
        </div>

        <div class="footer">
            <p>Gracias por leernos.</p>
            <p>Para cancelar la suscripción, haz clic <a href="{{ url('/cancelar-suscripcion?email=' . urlencode($email)) }}">aquí</a>.</p>
        </div>
    </div>
</body>
</html>
