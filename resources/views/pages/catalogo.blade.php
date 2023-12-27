@extends('layouts.guest')

@section('title', 'Galería de Imágenes')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
@endsection

@section('content')
<style>

    #calendar {
            margin: 0 auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        .fc-header-toolbar {
            margin-bottom: 20px;
        }
</style>
    <main>
        <div class="container-fluid">
            <div class="row">
                <!-- Campo de búsqueda -->
                <div class="mb-4">
                    <form action="{{ route('actividades.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="buscador" id="search" class="form-control"
                                placeholder="Escribe el nombre de la actividad">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Filtros en el aside -->
                <aside class="col-md-3">
                    <div class="mb-4">
                        <h3>Filtrar Actividades</h3>
                        <form action="{{ route('actividades.filter') }}" method="GET">
                            <div class="form-group">
                                <label for="categoria">Categoría:</label>
                                <select name="categoria" id="categoria" class="form-control">
                                    <option value="">Todas</option>
                                    <option value="aventura">Aventura</option>
                                    <option value="naturaleza">Naturaleza</option>
                                    <!-- Agrega más opciones de categoría aquí -->
                                </select>
                            </div>

                                <!-- ... otros campos de filtro ... -->
                                <div class="form-group">
                                    <label for="precio">Precio:</label>
                                    <select name="precio" id="precio" class="form-control">
                                        <option value="">Cualquier Precio</option>
                                        <option value="bajo">Bajo</option>
                                        <option value="medio">Medio</option>
                                        <option value="alto">Alto</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </form>
                    </div>
                </aside>

                <!-- Contenido principal -->
                <div class="col-md-9">
                    <!-- Encabezado -->
                    <header class="jumbotron">
                        <div class="container text-center">
                            <h1>Descubre Nuestras Actividades</h1>
                            <p>Explora una variedad de actividades emocionantes para todas las edades.</p>
                        </div>
                    </header>

                    <!-- Catálogo de Actividades -->
                    <section class="my-5">
                        <div class="row">
                            <!-- Actividades se mostrarán aquí -->
                            @foreach ($actividades as $actividad)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->nombre }}"
                                            class="card-img-top" alt="{{ $actividad->nombre }}">
                                        <div class="card-body">
                                            <h2 class="card-title">{{ $actividad->nombre }}</h2>
                                            <p class="card-text">{{ $actividad->descripcion }}</p>
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>Duración:</strong>
                                                    {{ $actividad->duracion }} min</li>
                                                <li class="list-group-item"><strong>Precio adulto:</strong>
                                                    {{ $actividad->precio_adulto }} €
                                                </li>
                                                <li class="list-group-item"><strong>Precio niño:</strong>
                                                    {{ $actividad->precio_nino }} €
                                                </li>
                                                </li>
                                                <li class="list-group-item"><strong>Aforo:</strong>
                                                    {{ $actividad->aforo }}</li>
                                            </ul>
                                            {{-- <a href="{{ route('actividades.show', $actividad->id) }}" class="btn btn-primary mt-3">Ver Detalles</a> --}}
                                            <!-- Agrega el botón "Reservar" -->
                                            <div class="lc-block">
                                                <button class="custom-btn boton" onclick="verDetalleActividad({{ $actividad->id }})">Ver más</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif




            <h2 class="my-4 text-center">Gestión de Horarios</h2>
            <div class="container my-4">
                <div class="filtro-idioma text-center">
                    <button class="btn btn-outline-primary mx-1" onclick="filtrarIdioma('Español')">Español</button>
                    <button class="btn btn-outline-secondary mx-1" onclick="filtrarIdioma('Inglés')">Inglés</button>
                    <button class="btn btn-outline-success mx-1" onclick="filtrarIdioma('Alemán')">Alemán</button>
                    <button class="btn btn-outline-danger mx-1" onclick="filtrarIdioma('Italiano')">Italiano</button>
                    <button class="btn btn-outline-warning mx-1" onclick="filtrarIdioma('Francés')">Francés</button>
                    <!-- Agrega más botones según los idiomas que manejes -->
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalles del Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal-body-content">
                            <!-- Contenido dinámico del modal -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12" style="margin-bottom: 4vh">

                    <!-- Calendario de horarios existentes -->
                    <div class="card">
                        <div class="card-header text-center">Calendario de Horarios</div>
                        <div class="card-body">
                            <div id="calendar" class="my-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Agregar FullCalendar y su script -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
        <!-- Agregar el script de Bootstrap (asegúrate de que tu proyecto ya tiene Bootstrap) -->


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'dayGridMonth,timeGridWeek,timeGridDay',
                        center: 'title'
                    },
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'dayGridMonth,timeGridWeek,timeGridDay',
                        center: 'title',
                        right: 'today prev,next'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Día'
                    },

                    locale: 'es',

                    eventClick: function(info) {
            @if(Auth::check())
                // Usuario autenticado: permite la reserva
                var horarioId = info.event.extendedProps.horario_id;
                window.location.href = `/reservar/${horarioId}`;
            @else
                // Usuario no autenticado: redirige al inicio de sesión
                window.location.href = '/login';
            @endif
        },
                    events: @json($events, JSON_PRETTY_PRINT)
                });

                // Renderizar el calendario
                calendar.render();
            });
        </script>

        <script>
            $(document).ready(function() {
                // Ocultar los mensajes de alerta después de 5 segundos
                setTimeout(function() {
                    $('.alert').fadeOut('slow');
                }, 5000); // 5 segundos
            });
        </script>
    </main>
    <script>
        function verDetalleActividad(actividadId) {
            // Construir la URL de la página de detalles de actividad
            const url = "{{ route('pages.detalleActividad', ':id') }}".replace(':id', actividadId);

            // Redirigir a la página de detalles de actividad
            window.location.href = url;
        }
    </script>
@endsection