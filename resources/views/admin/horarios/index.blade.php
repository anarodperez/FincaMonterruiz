@extends('layouts.admin')

@section('content')
<style>
    /* Estilos personalizados para el calendario */
    #calendar {
        /* max-width: 60vw; */
        margin: 0 auto;
    }

    /* Estilos personalizados para la tabla */
    #horarios-table {
        margin-top: 20px;
    }
</style>

<div class="container">
    <div class="text-center my-4">
        <h2 class="display-4 font-weight-bold text-primary">Gestión de horarios</h2>
        <p class="lead">Descubre y gestiona el horario de las actividades en el sistema.</p>
    </div>

    <!-- Agregar un botón para crear un nuevo horario -->
    <a href="{{ route('admin.horarios.create') }}" class="btn btn-primary mb-3">
        <span class="fas fa-plus"></span> Crear evento
    </a>

    <!-- Tabla para mostrar los horarios -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Días y Horas</th>
                    <th>Plazas Disponibles</th>
                    <th>Idioma</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actividades as $actividad)
                    <tr>
                        <td>{{ $actividad->nombre }}</td>
                        <td>
                            @foreach($actividad->horarios as $horario)
                                {{ $horario->dia_semana }} a las {{ \DateTime::createFromFormat('H:i:s', $horario->hora)->format('H:i') }}<br>
                            @endforeach
                        </td>

                        <td>{{ $actividad->horarios->first()->plazas_disponibles }}</td>
                        <td>{{ $actividad->horarios->first()->idioma }}</td>
                        <td>
                            <!-- Agrega aquí los enlaces o botones para acciones (editar, eliminar, etc.) -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarDetalles(id) {
        // Lógica para mostrar detalles en el modal, usando AJAX si es necesario
        // ...
        // Puedes actualizar el contenido dinámico del modal con información específica del horario
        // ...

        // Mostrar el modal
        $('#exampleModal').modal('show');
    }
</script>

@endsection




<!-- Agregar FullCalendar y su script -->
{{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title'
        },
        initialView: 'dayGridMonth',
        locale: 'es',
        dateClick: function (info) {
            // Fetch events for the clicked day
            var eventsForDay = calendar.getEventsOnDay(info.date);

            // Display relevant information in the modal
            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            var modalBody = document.getElementById('modal-body-content');

            modalBody.innerHTML = "<p><strong>Fecha Seleccionada:</strong> " + info.dateStr + "</p>";

            if (eventsForDay.length > 0) {
                // Display information from the first event (assuming there might be multiple)
                modalBody.innerHTML += "<p><strong>Actividad:</strong> " + eventsForDay[0].title + "</p>";
                modalBody.innerHTML += "<p><strong>Fecha y Hora:</strong> " + eventsForDay[0].start + "</p>";
                modalBody.innerHTML += "<p><strong>Idioma:</strong> " + eventsForDay[0].extendedProps.idioma + "</p>";
                modalBody.innerHTML += "<p><strong>Plazas disponibles:</strong> " + eventsForDay[0].extendedProps.plazas_disponibles + "</p>";
            } else {
                modalBody.innerHTML += "<p>No hay eventos para este día.</p>";
            }

            modal.show();
        },
        events: @json($events) // Convertir los eventos de PHP a JSON
    });
    calendar.render();
});

</script> --}}
