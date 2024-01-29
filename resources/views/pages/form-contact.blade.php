@extends('layouts.guest')
@section('title')
    Contáctanos
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/form-contact.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('js/contact-us.js') }}" defer></script>
@endsection
@section('content')
    <main>
        <section id="contact">
            <div class="contact-box">
                <div class="contact-links">
                    <div class="datos-empresa">
                        <p><strong>Dirección:</strong> Barriada la Polila, 123</p>
                        <p><strong>Teléfono:</strong> +34 123 456 789</p>
                        <p><strong>Email:</strong> fincaMonterruiz@gmail.com</p>
                    </div>
                    <div id="map" style="height: 400px"></div>
                    <script src="/js/mapa.js"></script>
                    <div class="links">
                    </div>
                </div>
                <div class="contact-form-wrapper">
                    <h5>
                        No dude en contactarnos si necesita ayuda o tiene alguna otra
                        pregunta.
                    </h5>
                    <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                        @csrf
                        <!-- Campo Nombre -->
                        <div class="form-item">
                            <input type="text" name="nombre" id="nombre" required />
                            <label for="nombre">Nombre y apellidos:</label>
                            <span class="error-message" id="errorNombre"></span>
                        </div>

                        <!-- Campo Email -->
                        <div class="form-item">
                            <input type="text" name="email" id="email" required />
                            <label for="email">Email:</label>
                            <span class="error-message" id="errorEmail"></span>
                        </div>

                        <!-- Campo Teléfono -->
                        <div class="form-item">
                            <input type="text" name="telefono" id="telefono" required />
                            <label for="telefono">Teléfono:</label>
                            <span class="error-message" id="errorTelefono"></span>
                        </div>

                        <!-- Campo Mensaje -->
                        <div class="form-item">
                            <textarea name="mensaje" id="mensaje" required></textarea>
                            <label for="mensaje">Mensaje:</label>
                            <span class="error-message" id="errorMensaje"></span>
                        </div>
                        <button class="submit-btn">Enviar</button>
                    </form>
                    <div id="successMessage" class="success-message" style="display: none;">
                        ¡Tu mensaje ha sido enviado con éxito!
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
