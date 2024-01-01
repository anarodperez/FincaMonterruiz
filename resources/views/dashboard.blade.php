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
        }

        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            border-bottom: 2px solid #007bff;
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
            color: white;
            border-radius: 5px;
            padding: 10px 15px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('content')
    <main>
        <div class="container py-5">

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                </ul>

                <!-- Contenido de las Pestañas -->
                <div class="tab-content">
                    {{-- Sección Reservas --}}
                    <div id="reservas" class="tab-pane fade show active">
                        <h2 class="tab-section-header">Tus Reservas</h2>
                        <!-- Permanent Reminder Message -->
                        <div class="alert alert-danger">
                            Recuerda que solo puedes cancelar hasta 48 horas antes del evento.
                        </div>
                        <div id="reservas" class="tab-pane fade show active">
                            <h3>Reservas Activas</h3>
                            <div class="row">
                                @foreach ($reservasActivas as $reserva)
                                    <div class="card card-reserva">
                                        <div class="card-body">
                                            <!-- Detalles de la reserva -->
                                            <p class="card-text">Fecha: {{ $reserva->horario->fecha }}</p>
                                            <p class="card-text">Hora: {{ $reserva->horario->hora }}</p>
                                            <p class="card-text">Estado: {{ $reserva->estado }}</p>
                                            @php
                                                $fechaReserva = \Carbon\Carbon::parse($reserva->horario->fecha . ' ' . $reserva->horario->hora);
                                                $ahora = \Carbon\Carbon::now();
                                                $diferenciaHoras = $ahora->diffInHours($fechaReserva, false);
                                            @endphp
                                            @if ($diferenciaHoras >= 48)
                                                <form action="{{ route('reservas.cancelar', $reserva->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Cancelar Reserva</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <!-- Sección Reservas Pasadas -->
                        <h3>Reservas Pasadas</h3>
                        <div class="row">
                            @foreach ($reservasPasadas as $reserva)
                                <div class="card card-reserva">
                                    <div class="card-body">
                                        <!-- Detalles de la reserva -->
                                        <p class="card-text">Fecha: {{ $reserva->horario->fecha }}</p>
                                        <p class="card-text">Hora: {{ $reserva->horario->hora }}</p>
                                        <p class="card-text">Estado: {{ $reserva->estado }}</p>

                                        <!-- Verificar si el usuario ya ha valorado la actividad -->
                                        {{-- @php
                                            $usuarioHaValorado = $reserva->actividad->valoraciones->where('user_id', auth()->user()->id)->count() > 0;
                                        @endphp --}}

                                        <!-- Mostrar el botón de valoración solo si el usuario no ha valorado la actividad -->
                                        {{-- @if (!$usuarioHaValorado)
                                            <a href=""
                                                class="btn btn-primary">Valorar Actividad</a>
                                        @endif --}}
                                        <a href=""
                                        class="btn btn-primary">Valorar Actividad</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <!-- Sección Valoraciones -->
                {{-- <div id="valoraciones" class="tab-pane fade">
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

                        </div>
                        <button class="btn btn-custom-secondary mt-3">Añadir Valoración</button>
                    </div> --}}
            </div>
        </div>
        </div>
    </main>
@endsection
