@extends('layouts.admin')

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

        /* Estilos para los eventos del calendario */
        /* .fc-event {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        } */
    </style>


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
                    <div class="modal-footer">
                        <!-- Formulario para borrar el horario -->
                        <form id="borrarHorarioForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="horario_id" id="horario_id" value="">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Borrar</button>
                        </form>


                        <!-- Dentro del modal -->
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
                    <!-- Enlace para redirigir a la página de selección de horario para borrar -->
                    {{-- <a href="{{ route('admin.horarios.select-delete') }}" class="btn btn-danger">
                        <span class="fas fa-minus"></span> Borrar evento
                    </a> --}}
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
                    // Extraer los detalles del horario del evento seleccionado
                    var horarioId = info.event.extendedProps.horario_id;
                    var actividad = info.event.title;
                    var fechaHora = info.event.start.toLocaleString();
                    var idioma = info.event.extendedProps.idioma;
                    var frecuencia = info.event.extendedProps.frecuencia;

                    // Actualizar el contenido del modal con los detalles del horario
                    var modalBody = document.getElementById('modal-body-content');
                    modalBody.innerHTML = "<p><strong>Actividad:</strong> " + actividad + "</p>" +
                        "<p><strong>Fecha y Hora:</strong> " + fechaHora + "</p>" +
                        "<p><strong>Idioma:</strong> " + idioma + "</p>" +
                        "<p><strong>Id:</strong> " + horarioId + "</p>" +
                        "<p><strong>Frecuencia:</strong> " + frecuencia + "</p>";

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

                events: @json($events, JSON_PRETTY_PRINT)
            });

            // Renderizar el calendario
            calendar.render();
        });
    </script>
    <script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas borrar este horario?')) {
                document.getElementById('borrarHorarioForm').submit();
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Ocultar los mensajes de alerta después de 5 segundos
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000); // 5 segundos
        });
    </script>
@endsection
