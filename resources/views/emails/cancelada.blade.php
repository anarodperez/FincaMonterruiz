<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Suscripción Cancelada</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
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
            font-size: 0.8em;
            color: #666666;
        }

        .button {
            background-color: #5c7c64;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #4a644f;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo-and-name">
                <img src="{{ asset('img/logo.png') }}" alt="Logo de Finca Monterruiz">
                <h2>Finca Monterruiz</h2>
            </div>
            <h1>Suscripción Cancelada</h1>
        </div>

        <div class="content">
            <p>La suscripción para el correo electrónico <strong>{{ $email }}</strong> ha sido cancelada con
                éxito.</p>
            <p>Si crees que ha sido un error o deseas suscribirte nuevamente, por favor haz clic en el botón de abajo.
            </p>
            <a href="{{ url('/') }}" class="button">Volver a la Página Principal</a>
        </div>
        <div class="footer">
            <p>Gracias por haber sido parte de nuestra comunidad.</p>
        </div>
    </div>
</body>

</html>
