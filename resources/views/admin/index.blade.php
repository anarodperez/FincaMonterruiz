@extends('layouts.admin')

@section('title', 'Portal de administración')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Agrega estilos personalizados aquí si es necesario */
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Contenido principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Panel de Control</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button class="btn btn-sm btn-outline-secondary">Acción 1</button>
                            <button class="btn btn-sm btn-outline-secondary">Acción 2</button>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            Otras acciones
                        </button>
                    </div>
                </div>

                <!-- Resumen del enoturismo -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Actividades Disponibles</h5>
                                <p class="card-text">30</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Categorías</h5>
                                <p class="card-text">10</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios Registrados</h5>
                                <p class="card-text">500</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valoraciones y comentarios -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Valoraciones y Comentarios</h5>
                                <!-- Puedes mostrar una lista de las últimas valoraciones y comentarios -->
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Usuario 1</span>
                                            <span class="badge badge-primary badge-pill">4.5</span>
                                        </div>
                                        <p>¡Excelente actividad! Muy recomendada.</p>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Usuario 2</span>
                                            <span class="badge badge-primary badge-pill">3.8</span>
                                        </div>
                                        <p>Buena experiencia, pero podría mejorar en algunos aspectos.</p>
                                    </li>
                                    <!-- Agrega más elementos según sea necesario -->
                                </ul>
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
                                <!-- Puedes mostrar una lista de las últimas reservas -->
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Actividad 1</span>
                                            <span class="badge badge-primary badge-pill">10:00 AM</span>
                                        </div>
                                        <p>Usuario: Usuario 3</p>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Actividad 2</span>
                                            <span class="badge badge-primary badge-pill">2:00 PM</span>
                                        </div>
                                        <p>Usuario: Usuario 4</p>
                                    </li>
                                    <!-- Agrega más elementos según sea necesario -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horarios de actividades -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Horarios de Actividades</h5>
                                <!-- Puedes mostrar una tabla con los horarios de las actividades -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Actividad</th>
                                            <th>Día</th>
                                            <th>Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Actividad 1</td>
                                            <td>Lunes</td>
                                            <td>10:00 AM</td>
                                        </tr>
                                        <tr>
                                            <td>Actividad 2</td>
                                            <td>Miércoles</td>
                                            <td>3:00 PM</td>
                                        </tr>
                                        <!-- Agrega más filas según sea necesario -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
