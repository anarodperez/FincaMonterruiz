@extends('layouts.admin')

@section('content')
<style>

/* Estilos personalizados para la tabla */
.table-container {
    max-height: 500px;
    overflow-y: auto;
    margin-bottom: 4vh;
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
                </tr>
            </thead>
            <tbody>
                @foreach($actividades as $actividad)
                    <tr>
                        <td>{{ $actividad->nombre }}</td>
                        <td>
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Hora</th>
                                        <th>Plazas</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actividad->horarios as $horario)
                                        <tr>
                                            <td>{{ $horario->dia_semana }}</td>
                                            <td>{{ \DateTime::createFromFormat('H:i:s', $horario->hora)->format('H:i') }}</td>
                                            <td>{{ $horario->plazas_disponibles }}</td>
                                            <td>
                                                <!-- Agregar botones de acción (editar, borrar, etc.) aquí -->
                                                <button class="btn btn-sm btn-info" onclick="editarHorario({{ $horario->id }})">Editar</button>
                                                <button class="btn btn-sm btn-danger" onclick="borrarHorario({{ $horario->id }})">Borrar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $actividades->links() }} <!-- Muestra la paginación -->
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
