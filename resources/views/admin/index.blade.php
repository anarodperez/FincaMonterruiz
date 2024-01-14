@extends('layouts.admin')

@section('title', 'Portal de administración')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Contenido principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Panel de Control</h1>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Actividades Disponibles</h5>
                                @if (isset($cantidadActividades))
                                    <p class="card-text">{{ $cantidadActividades }}</p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Valoraciones</h5>
                                @if (isset($cantidadValoraciones))
                                    <p class="card-text">{{ $cantidadValoraciones }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios Registrados</h5>
                                @if (isset($usuariosRegistrados))
                                    <p class="card-text">{{ $usuariosRegistrados }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservas recientes -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reservas Recientes</h5>
                                <ul class="list-group">
                                    @if (isset($reservasRecientes))
                                        @foreach ($reservasRecientes as $reserva)
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>{{ $reserva->actividad->nombre }}</span>
                                                    <span class="badge badge-primary badge-pill">{{ $reserva->hora }}</span>
                                                </div>
                                                <p>Usuario: {{ $reserva->usuario->nombre }}</p>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valoraciones y comentarios -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card" style="margin-bottom: 8vh;">
                            <div class="card-body">
                                <h5 class="card-title">Valoraciones y Comentarios</h5>
                                <!-- lista de las últimas valoraciones y comentarios -->
                                <ul class="list-group">
                                    @if (isset($ultimasValoraciones))
                                        @foreach ($ultimasValoraciones as $valoracion)
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>{{ $valoracion->user->nombre }}</span>
                                                    <span
                                                        class="badge badge-primary badge-pill">{{ $valoracion->puntuacion }}
                                                    </span>
                                                </div>
                                                <p>{{ $valoracion->comentario }}</p>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
