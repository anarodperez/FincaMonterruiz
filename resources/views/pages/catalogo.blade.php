@extends('layouts.guest')

@section('title', 'Catálogo de actividades')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
@endsection

@section('content')
    <main>
        <div class="container-fluid">
            <!-- Encabezado -->
            <header class="jumbotron">
                <div class="container text-center">
                    <h1>Descubre Nuestras Actividades</h1>
                    <p>Explora una variedad de actividades emocionantes para todas las edades.</p>
                </div>
            </header>
            <div class="row">
                <!-- Campo de búsqueda con ícono de lupa -->
                <div class="d-flex justify-content-center align-items-center busqueda" style="position: relative;">
                    <input type="text" id="search" class="form-control" placeholder="Escribe el nombre de la actividad"
                        onkeyup="buscarActividades()">
                </div>

                <!-- Filtros en el aside -->
                <aside class="col-md-3">
                    <div class="mb-4">
                        <h3>Filtrar Actividades</h3>
                        <form action="{{ route('catalogo.filter') }}" method="GET" name="form">
                            <div class="form-group">
                                <label for="publico">Público objetivo:</label>
                                <select name="publico" id="publico" class="form-control">
                                    <option value="">Selecciona una opción</option>
                                    <option value="todos">Para todos los públicos</option>
                                    <option value="adultos">Solo para adultos</option>
                                    <option value="ninos">Solo para niños</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="duracion">Duración:</label>
                                <select name="duracion" id="duracion" class="form-control">
                                    <option value="">Cualquier Duración</option>
                                    <option value="corta">Corta (menos de 1 hora)</option>
                                    <option value="media">Media (1-2 horas)</option>
                                    <option value="larga">Larga (más de 2 horas)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="precio_min">Precio Mínimo:</label>
                                <input type="number" name="precio_min" id="precio_min" class="form-control"
                                    value="{{ $filtros['precio_min'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="precio_max">Precio Máximo:</label>
                                <input type="number" name="precio_max" id="precio_max" class="form-control"
                                    value="{{ $filtros['precio_max'] ?? '' }}">
                            </div>
                            <div class="botones">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <button type="button" class="btn btn-danger" onclick="borrarFiltros()">Borrar
                                    Filtros</button>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Contenido principal -->
                <div class="col-md-9">

                    <!-- Catálogo de Actividades -->
                    <section class="my-5">
                        <div id="search-results" class="row">
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
                                            {{-- <div class="lc-block">
                                                <button class="custom-btn boton"
                                                    onclick="verDetalleActividad({{ $actividad->id }})">Ver más</button>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Enlaces de paginación -->
                        {{ $actividades->links('pagination::bootstrap-4', ['class' => 'mi-paginacion-personalizada']) }}


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
            <!-- Modal: mensaje AFORO COMPLETO -->
            <div class="modal fade" id="eventoCompletoModal" tabindex="-1" aria-labelledby="eventoCompletoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventoCompletoModalLabel">Horario Completo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Este horario está completo. Por favor, selecciona otro horario.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

        <script>
            function getColorForActivity(activityId) {
                // Convertir el ID en un número (si no lo es ya)
                var idNumber = parseInt(activityId);
                if (isNaN(idNumber)) {
                    // Si el ID no es numérico, usa un hash simple para convertirlo en un número
                    idNumber = activityId.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0);
                }

                // Generar color
                var hue = idNumber * 137.508; // Ángulo dorado aproximado
                var saturation = 70; // Aumentar la saturación para colores más intensos
                var lightness = 50; // Luminosidad que permite colores vivos pero no demasiado claros u oscuros

                return `hsl(${hue % 360}, ${saturation}%, ${lightness}%)`;
            }
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
                        var aforoDisponible = info.event.extendedProps.aforoDisponible;

                        if (aforoDisponible === 0) {
                            // Si el aforo es 0, muestra un mensaje y no redirige
                            $('#eventoCompletoModal').modal('show');
                        } else {
                            // Si hay aforo, procede con la lógica de redirección
                            @if (Auth::check())
                                // Usuario autenticado: permite la reserva
                                var horarioId = info.event.extendedProps.horario_id;
                                window.location.href = `/reservar/${horarioId}`;
                            @else
                                // Usuario no autenticado: redirige al inicio de sesión
                                window.location.href = '/login';
                            @endif
                        }
                    },
                    eventContent: function(arg) {
                        var aforoDisponible = arg.event.extendedProps.aforoDisponible;
                        var actividadId = arg.event.id;

                        // Contenedor principal del evento
                        var eventWrapper = document.createElement('div');
                        eventWrapper.classList.add('custom-event');


                        // Hora del evento
                        var timeElement = document.createElement('div');
                        timeElement.classList.add('event-time');
                        timeElement.innerHTML = arg.event.start.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        // Título del evento
                        var titleElement = document.createElement('div');
                        titleElement.classList.add('event-title');
                        titleElement.innerHTML = arg.event.title;
                        titleElement.style.color = getColorForActivity(actividadId);

                        //Idioma
                        var idiomaElement = document.createElement('div');
                        idiomaElement.classList.add('event-idioma');
                        idiomaElement.innerHTML = arg.event.extendedProps.idioma;


                        // Construcción del contenido del evento
                        eventWrapper.appendChild(titleElement);
                        eventWrapper.appendChild(timeElement);
                        eventWrapper.appendChild(idiomaElement);


                       // Estado de aforo
                    if (aforoDisponible === 0) {
                        var aforoElement = document.createElement('div');
                        aforoElement.classList.add('event-aforo');
                        aforoElement.innerHTML = "COMPLETO";
                        aforoElement.style.color = 'red';
                        eventWrapper.appendChild(aforoElement);
                    }

                        return {
                            domNodes: [eventWrapper]
                        };
                    },
                    events: @json($events, JSON_PRETTY_PRINT)
                });

                // Renderizar el calendario
                calendar.render();

                // Filtrar eventos pasados
                calendar.getEvents().forEach(function(event) {
                    if (event.start < new Date()) {
                        event.remove(); // Elimina los eventos pasados
                    }
                });
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

    <script>
        function buscarActividades() {
            var searchQuery = document.getElementById('search').value;
            var normalizedQuery = normalizeString(searchQuery);

            fetch('/buscar-actividades?q=' + encodeURIComponent(normalizedQuery))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Datos recibidos:", data);

                    var html = '';
                    data.forEach(actividad => {
                        html += `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="${actividad.imagen}" class="card-img-top" alt="${actividad.nombre}">
                                <div class="card-body">
                                    <h5 class="card-title">${actividad.nombre}</h5>
                                    <p class="card-text">${actividad.descripcion}</p>
                                    <!-- Otros detalles de la actividad -->
                                </div>
                            </div>
                        </div>
                    `;
                    });
                    document.getElementById('search-results').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error al realizar la búsqueda:', error);
                });
        }

        function normalizeString(string) {
            string = string.toLowerCase();
            string = string.normalize("NFD").replace(/[\u0300-\u036f]/g, ""); // Quita las tildes
            return string;
        }
    </script>
    <script>
        function borrarFiltros() {
            // Restablecer los campos del formulario
            document.getElementById('publico').value = '';
            document.getElementById('duracion').value = '';
            // Verifica si cada elemento existe antes de intentar manipularlo
            if (document.getElementById('precio_min')) {
                document.getElementById('precio_min').value = '';
            }
            if (document.getElementById('precio_max')) {
                document.getElementById('precio_max').value = '';
            }

            document.forms['form'].submit();
        }
    </script>
@endsection
