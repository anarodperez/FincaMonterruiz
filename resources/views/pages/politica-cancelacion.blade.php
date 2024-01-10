<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        /* Color de fondo suave */
        margin: 0;
        padding: 0;
    }

    .container-2 {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        min-height: 80vh;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top: 6vh;
        margin-bottom: 6vh;
    }


    a {
        color: #007bff;
        text-decoration: none;
    }


    a:hover {
        text-decoration: underline;
    }

    .container-2 h1 {
        color: #333;
        margin-top: 30px;
        margin-bottom: 4vh;
        text-align: center;

    }

    .container-2 h2 {
        color: #333;
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .container-2 p {
        font-size: 1em;
        line-height: 1.6;
        color: #666;
        margin-bottom: 20px;
    }
</style>


@extends('layouts.guest') {{-- Asume que tienes un layout base --}}

@section('title', 'Política de Cancelación de Reservas')

@section('content')

    <div class="container-2">
        <h1>Política de Cancelación de Reservas</h1>
        <p>Entendemos que a veces los planes cambian y puede ser necesario cancelar una reserva. Nuestra política de
            cancelación es la siguiente:</p>

        <h2>Cancelación sin Penalización</h2>
        <p>Las cancelaciones realizadas con más de 48 horas de antelación a la fecha y hora de la reserva no incurrirán en
            ningún cargo.</p>

        <h2>Cancelación Tardía</h2>
        <p>Las cancelaciones realizadas con menos de 48 horas de antelación a la fecha y hora de la reserva pueden estar
            sujetas a un cargo por cancelación. Este cargo compensa los gastos administrativos y la posible pérdida de
            ingresos debido a la imposibilidad de reasignar el espacio reservado.</p>

        <h2>Cómo Cancelar</h2>
        <p>Para cancelar su reserva, por favor utilice el siguiente enlace: <a href="link-de-cancelacion">Cancelar
                Reserva</a>. También puede contactarnos directamente a través de nuestro correo electrónico o número de
            teléfono proporcionado en nuestra página de contacto.</p>

        <h2>Preguntas o Preocupaciones</h2>
        <p>Si tiene alguna pregunta o preocupación respecto a esta política, no dude en contactarnos. Estamos aquí para
            ayudar y asegurarnos de que su experiencia con nosotros sea lo más satisfactoria posible.</p>

    @endsection
