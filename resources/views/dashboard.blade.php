@extends('layouts.guest')

@section('title')
    Panel de Usuario
@endsection

@section('css')
    <!-- Tus estilos y enlaces CSS existentes aquí -->
    <style>
        /* Estilos generales del panel de usuario */
        .user-dashboard {
            background-color: #f4f4f4;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para las pestañas y su contenido */
        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: #0275d8;
            /* Color de tu elección */
        }

        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            border-bottom: 2px solid #007bff;
            /* Color de tu elección */
        }

        .tab-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: -1px;
        }

        /* Estilo para las tarjetas en las secciones */
        .card-reserva {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .card-reserva:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transform: scale(1.05);
        }

        /* Estilos adicionales para botones y enlaces */
        .btn-custom {
            background-color: #007bff;
            /* Color de tu elección */
            color: white;
            border-radius: 5px;
            padding: 10px 15px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            /* Color más oscuro de tu elección */
        }
    </style>
@endsection

@section('content')
    <main>
        <div class="container py-5">
            <!-- Panel de Usuario -->
            <div class="user-dashboard">
                <!-- Pestañas de Navegación -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#reservas">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#valoraciones">Valoraciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#perfil">Perfil</a>
                    </li>
                </ul>

                <!-- Contenido de las Pestañas -->
                <div class="tab-content">
                    <!-- Sección Reservas -->
                    <div id="reservas" class="tab-pane fade show active">
                        <h2 class="tab-section-header">Tus Reservas</h2>
                        <div class="row">
                            <!-- Tarjeta de Reserva de Ejemplo -->
                            <div class="col-md-4 mb-4">
                                <div class="card card-detail">
                                    <div class="card-body">
                                        <h5 class="card-title">Reserva en Hotel Playa Azul</h5>
                                        <p class="card-text">Fecha: 2023-07-15</p>
                                        <p class="card-text">Habitación: Doble con vista al mar</p>
                                        <p class="card-text">Precio: $200/noche</p>
                                        <a href="#" class="btn btn-custom-primary">Ver Detalles</a>
                                        <a href="#" class="btn btn-custom-secondary">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Repetir con más tarjetas de reserva de prueba... -->
                        </div>
                        <button class="btn btn-custom-primary mt-3">Nueva Reserva</button>
                    </div>


                    <!-- Sección Valoraciones -->
                    <div id="valoraciones" class="tab-pane fade">
                        <h2 class="tab-section-header">Valoraciones Recientes</h2>
                        <div class="row">
                            <!-- Tarjeta de Valoración de Ejemplo -->
                            <div class="col-md-4 mb-4">
                                <div class="card card-detail">
                                    <div class="card-body">
                                        <h5 class="card-title">Restaurante Mar y Tierra</h5>
                                        <p class="card-text">Valoración: ★★★★☆</p>
                                        <p class="card-text">"Excelente comida y servicio. Un ambiente agradable y
                                            acogedor."</p>
                                        <a href="#" class="btn btn-custom-primary">Editar Valoración</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Repetir con más tarjetas de valoración de prueba... -->
                        </div>
                        <button class="btn btn-custom-secondary mt-3">Añadir Valoración</button>
                    </div>


                    <!-- Sección Perfil -->
                    <div id="perfil" class="tab-pane fade">
                        <h2 class="tab-section-header">Tu Perfil</h2>
                        <!-- Detalles del perfil -->
                        <div class="card card-detail">
                            <div class="card-body">
                                <h5 class="card-title">Nombre de Usuario</h5>
                                <p class="card-text">Correo Electrónico: usuario@ejemplo.com</p>
                                <p class="card-text">Teléfono: +1 234 567 8901</p>
                                <p class="card-text">Dirección: Calle Falsa 123, Ciudad, País</p>
                            </div>
                        </div>
                        <button class="btn btn-custom-primary mt-3">Editar Perfil</button>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicialización de Swiper para Reservas
            const swiperReservas = new Swiper('.swiper-reservas', {
                // Configuración de Swiper
            });

            // Repetir para otras secciones si es necesario
        });
    </script>
@endsection
