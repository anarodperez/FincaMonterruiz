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
            text-align: center;
        }

        .header {
            background-color: #5c7c64;
            color: white;
            padding: 20px;
            text-align: center; /* Centra el texto */
        justify-content: center; /* Centra los elementos flexibles horizontalmente */
        display: flex; /* Habilita Flexbox */
        flex-direction: column; /* Alinea los elementos en una columna */
        align-items: center;
        }

        .card {
            background-color: #fff;
            margin: 20px 0;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            border-left: 5px solid #4e8975;
        }

        .card img {
            max-width: 100%;
            border-radius: 10px;
            border-radius: 10px;
        }

        .content {
            margin-top: 20px;
        }

        .content h2,
        .content h3 {
            color: #333;
            margin-bottom: 10px;

        }

        .content p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px; /* Tamaño más pequeño para el texto del pie de página */
            color: #888; /* Color más suave para el pie de página */
            text-align: center;
        }

        .footer a {
            color: #5c7c64;
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
                <p style="font-size: 16px; color: #666; line-height: 1.5;">Descubre lo último en experiencias de
                    enoturismo con nuestra selección mensual de aventuras en
                    viñedos.</p>
            </div>

            <div class="card">
                <h2>{{ $newsletter->titulo }}</h2>
                <p>{!! html_entity_decode($newsletter->contenido) !!}</p>
                @if ($newsletter->imagen_url)
                    <img src="{{ $newsletter->imagen_url }}" alt="Imagen de la Newsletter">
                @endif
            </div>
        </div>

        <div class="footer">
            <p>Gracias por leernos. Para cancelar la suscripción, haz clic <a
                    href="{{ url('http://127.0.0.1:8000/cancelar-suscripcion?email=' . urlencode($email)) }}">aquí</a>.
            </p>
        </div>
    </div>
</body>

</html>
