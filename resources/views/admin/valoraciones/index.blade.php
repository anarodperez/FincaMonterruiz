@extends('layouts.admin')

@section('content')
    <div class="text-center my-4">
        <h2 class="display-4 font-weight-bold titulo">Valoraciones de los usuarios</h2>
        <p class="lead">Descubre y gestiona la lista de valoraciones de los usuarios.</p>
    </div>

    <div class="content">
        <div class="contenedor-tabla">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Usuario</th>
                        <th>Puntuación</th>
                        <th>Comentario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($valoraciones as $valoracion)
                        <tr>
                            <td>{{ $valoracion->actividad->nombre }}</td>
                            <td>{{ $valoracion->user->nombre }} {{ $valoracion->user->apellido1 }}
                                {{ $valoracion->user->apellido2 }}</td>
                            <td>
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $valoracion->puntuacion)
                                        <span class="text-warning">★</span>
                                    @else
                                        <span class="text-secondary">★</span>
                                    @endif
                                @endfor
                            </td>
                            <td>{{ $valoracion->comentario }}</td>
                            <td>{{ $valoracion->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteValoracionModal" data-id="{{ $valoracion->id }}">Borrar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal de Confirmación de Borrado -->
            <div class="modal fade" id="deleteValoracionModal" tabindex="-1" aria-labelledby="deleteValoracionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteValoracionModalLabel">Confirmar Borrado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que quieres borrar esta valoración?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form id="deleteValoracionForm" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enlaces de paginación -->
            {{ $valoraciones->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <script>
        //Para el modal
        document.addEventListener("DOMContentLoaded", function() {
            var valoracionModal = document.getElementById('deleteValoracionModal');
            valoracionModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var valoracionId = button.getAttribute('data-id');
                var deleteForm = document.getElementById('deleteValoracionForm');
                deleteForm.action = '/valoraciones/' + valoracionId;
            });
        });
    </script>
@endsection
