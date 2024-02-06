@extends('layouts.admin')
@section('title')
    Admin | Horarios
@endsection

@section('title', 'Admin | Horarios')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" style="margin-top: 13px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" style="margin-top: 13px;">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="my-4 text-center display-4 font-weight-bold titulo">Gestión de Horarios</h2>
        <div class="container my-4">
            <div class="filtro-idioma text-center">
                <button class="btn btn-outline-primary mx-1" onclick="filtrarIdioma('Español')">Español</button>
                <button class="btn btn-outline-secondary mx-1" onclick="filtrarIdioma('Inglés')">Inglés</button>
                <button class="btn btn-outline-warning mx-1" onclick="filtrarIdioma('Francés')">Francés</button>
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
                    </div>
                    <div class="modal-footer">
                        <!-- Formulario para borrar el horario -->
                        <form id="borrarHorarioForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="horario_id" id="horario_id" value="">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Borrar</button>
                        </form>
                        <a href="#" id="editHorarioLink" class="btn btn-primary">Editar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12" style="margin-bottom: 4vh">
                <p>
                    <a href="{{ route('admin.horarios.create') }}" class="btn btn-primary">
                        <span class="fas fa-plus"></span> Crear evento
                    </a>
                </p>

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


        var calendar;

        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
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
                    // Extraer los detalles del horario del evento seleccionado
                    var horarioId = info.event.extendedProps.horario_id;
                    var actividad = info.event.title;
                    var fechaHora = info.event.start.toLocaleString();
                    var idioma = info.event.extendedProps.idioma;
                    var frecuencia = info.event.extendedProps.frecuencia;
                    var modalBody = document.getElementById('modal-body-content');

                    var aforoDisponible = info.event.extendedProps.aforoDisponible;
                    var estadoAforo = aforoDisponible === 0 ? "COMPLETO" : "Disponible";

                    modalBody.innerHTML = "<p><strong>Actividad:</strong> " + actividad + "</p>" +
                        "<p><strong>Fecha y Hora:</strong> " + fechaHora + "</p>" +
                        "<p><strong>Idioma:</strong> " + idioma + "</p>" +
                        "<p><strong>Id:</strong> " + horarioId + "</p>" +
                        "<p><strong>Frecuencia:</strong> " + frecuencia + "</p>" +
                        "<p><strong>Aforo:</strong> " + estadoAforo + "</p>";

                    // Actualizar la acción del formulario para el borrado
                    var form = document.getElementById('borrarHorarioForm');
                    form.action = '/admin/horarios/' + horarioId;

                    // Establecer el valor del horario_id en el formulario oculto
                    document.getElementById('horario_id').value = horarioId;

                    // Actualiza el enlace del botón de edición
                    var editLink = document.getElementById('editHorarioLink');
                    editLink.href = `/admin/horarios/edit/${horarioId}`;


                    // Mostrar el modal
                    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
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

            filtrarIdioma('Todos');
        });

        function filtrarIdioma(idiomaSeleccionado) {
            // Utiliza la instancia del calendario almacenada en la variable global
            var eventos = calendar.getEvents();

            eventos.forEach(function(event) {
                if (idiomaSeleccionado === 'Todos' || event.extendedProps.idioma === idiomaSeleccionado) {
                    event.setProp('display', 'block'); // Muestra el evento
                } else {
                    event.setProp('display', 'none'); // Oculta el evento
                }
            });
        }
    </script>
    <script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas borrar este horario?')) {
                document.getElementById('borrarHorarioForm').submit();
            }
        }

        $(document).ready(function() {
            // Ocultar los mensajes de alerta después de 5 segundos
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000); // 5 segundos
        });
    </script>
@endsection
