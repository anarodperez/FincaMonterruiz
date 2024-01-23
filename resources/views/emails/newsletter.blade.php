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
            max-width: 1000px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #5c7c64;
            color: white;
            padding: 10px;
            text-align: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
        }

        .card {
            background-color: #fff;
            margin: 10px 0;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            /* Bordes redondeados */
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            /* Bordes redondeados para las imágenes */
        }

        .content {
            margin-top: 20px;
        }

        .content h2,
        .content h3 {
            color: #4a235a;

        }

        .footer {
            margin-top: 20px;
            font-size: 1.1em;
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
            {{-- Logo y Nombre del Viñedo --}}
            <h1 class="text-center">Boletín Informativo de Finca Monterruiz</h1>
        </div>

        <div class="content">
            <div class="card">
                <h2>Saludos amantes del vino,</h2>
                <p style="font-size: 16px; color: #666; line-height: 1.5;">Descubre lo último en experiencias de enoturismo con nuestra selección mensual de aventuras en
                    viñedos.</p>
            </div>

            <div class="card">
                <h3 style="font-size: 24px; color: #333; margin-bottom: 10px;">{{ $newsletter->titulo }}</h3>

                <div style="font-size: 16px; color: #666; line-height: 1.5;">
                    {!! html_entity_decode($newsletter->contenido) !!}
                </div>

            </div>
        </div>

        <div class="footer">
            <p>Gracias por leernos. Para cancelar la suscripción, haz clic <a
                    href="{{ url('http://127.0.0.1:8000/cancelar-suscripcion?email=' . urlencode($email)) }}">aquí</a>.</p>
        </div>
    </div>
</body>

</html>
