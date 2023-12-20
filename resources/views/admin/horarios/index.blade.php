@extends('layouts.admin')

@section('content')
    <style>
        /* Estilos personalizados para el calendario */
        #calendar {
            /* max-width: 60vw; */
            margin: 0 auto;
        }
    </style>
    <div class="container">
        <h2 class="my-4 text-center">Gestión de Horarios</h2>
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
                        <form id="borrarHorarioForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <!-- Agrega el input para el ID del horario -->
                            <input type="hidden" name="horario_id" id="horario_id" value="">
                            <!-- Agrega el botón de confirmación en tu modal -->
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">Borrar</button>
                        </form>
                        <button type="button" class="btn btn-primary">Guardar cambios</button>
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

    <!-- Integrar Bootstrap (asegúrate de que tu proyecto ya tiene Bootstrap) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <!-- Agregar FullCalendar y su script -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <!-- Agregar el script de Bootstrap (asegúrate de que tu proyecto ya tiene Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title'
                },
                initialView: 'dayGridMonth',
                locale: 'es',
                eventClick: function(info) {

                    // Utiliza la propiedad horario_id del evento para obtener el ID del horario
    var horarioId = info.event.extendedProps.horario_id;

// Actualiza el valor del campo oculto en el formulario del modal
document.getElementById('horario_id').value = horarioId;
                    var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    // Construir el contenido dinámico del modal con información del evento
                    var modalBody = document.getElementById('modal-body-content');
                    modalBody.innerHTML = "<p><strong>Actividad:</strong> " + info.event.title + "</p>";
                    modalBody.innerHTML += "<p><strong>Fecha y Hora:</strong> " + info.event.start
                        .toLocaleString() + "</p>";
                    modalBody.innerHTML += "<p><strong>Idioma:</strong> " + info.event.extendedProps
                        .idioma + "</p>";
                    modalBody.innerHTML += "<p><strong>Id:</strong> " + info.event.extendedProps
                        .horario_id + "</p>";


                    modal.show();
                },

                events: @json($events, JSON_PRETTY_PRINT)

            });

            // Antes de agregar nuevos eventos, limpiar los eventos existentes
            // calendar.getEvents().forEach(function(event) {
            //     event.remove();
            // });


            // Renderizar el calendario
            calendar.render();
        });
    </script>
    <script>
        function confirmDelete() {
            // Obtener el valor del horario_id desde el formulario
            var horarioId = document.getElementById('horario_id').value;

            if (confirm('¿Estás seguro de que deseas borrar este horario?')) {
                // Establecer la URL con el ID del horario
                var deleteUrl = '/admin/horarios/' + horarioId; // Usar el valor de horarioId
                document.getElementById('borrarHorarioForm').action = deleteUrl;
                document.getElementById('borrarHorarioForm').submit();
            }
        }
    </script>
@endsection
