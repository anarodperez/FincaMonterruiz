@extends('layouts.guest')

@section('title', 'Política de Cancelación de Reservas')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/aviso-legal.css') }}">
@endsection


@section('content')

    <div class="container-2 my-5">
        <h1 class="text-center">Política de Cancelación de Reservas</h1>
        <hr>

        <p class="parrafo">
            Nuestra política de cancelación está diseñada para ser justa tanto para nuestros clientes como para la gestión
            de nuestra empresa. A continuación, encontrará los detalles de nuestra política.
        </p>

        <section class="my-4">
            <h2>Cancelación por Parte del Cliente</h2>
            <p class="parrafo">
                Las cancelaciones realizadas con más de 48 horas de antelación a la fecha y hora de la reserva
                no incurrirán en ningún cargo. Sin embargo, el usuario no podrá cancelarla si se encuentra dentro de las 48
                horas previas a la
                fecha y hora programadas. En tales casos, el pago realizado por la reserva no será reembolsable.

            <p class="parrafo">
                Esta medida se adopta para asegurar la disponibilidad de nuestros servicios a otros clientes y para cubrir
                los
                costos operativos ya comprometidos para la reserva.
            </p>
        </section>

        <section class="my-4">
            <h2>Cancelación por Parte de la Empresa</h2>
            <p class="parrafo">
                En el caso excepcional de que nuestra empresa deba cancelar una reserva o actividad, garantizamos un reembolso íntegro a nuestros clientes. Esta situación puede presentarse por diversas razones, como condiciones climáticas adversas, situaciones imprevistas o cualquier otro factor que impida la realización de la actividad con los estándares de calidad y seguridad esperados.
            </p>
            <p class="parrafo">
                En tales circunstancias, nos pondremos en contacto con usted lo antes posible para informarle sobre la cancelación y proceder con el reembolso total.
            </p>
        </section>

        <section class="my-4">
            <h2>Cómo Cancelar</h2>
            <p class="parrafo">Para cancelar su reserva, por favor utilice el siguiente enlace:  <a href="{{ route('dashboard') }}" class="btn-enlace-contact">Cancelar reserva</a>. También puede contactarnos directamente a través de nuestro correo electrónico o número de
                teléfono proporcionado en nuestra página de contacto.</p>
        </section>

        <section class="my-4">
            <h2>Excepciones y Casos de Fuerza Mayor</h2>
            <p class="parrafo">
                Entendemos que existen circunstancias fuera de nuestro control, tanto para nuestros clientes como para nosotros. En situaciones de fuerza mayor, nos comprometemos a revisar cada caso individualmente y ofrecer la máxima flexibilidad posible.
            </p>
        </section>

        <section class="my-4">
            <h2>Preguntas o Preocupaciones</h2>
            <p class="parrafo">Si tiene alguna pregunta o preocupación respecto a esta política, no dude en  <a href="{{ route('pages.form-contact') }}" class="btn-enlace-contact">contactarnos</a>.
                Estamos aquí para
                ayudar y asegurarnos de que su experiencia con nosotros sea lo más satisfactoria posible.
            </p>
        </section>
    @endsection
