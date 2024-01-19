@extends('admin.index')

@section('title', 'Admin | Reservas')

<style>
    .buscador {
        max-width: 500px;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
    }
</style>

@section('content')
    <div class="container">
        <div class="text-center my-4">
            <h2 class="display-4 font-weight-bold">Listado de Reservas</h2>
            <p class="lead">Descubre y gestiona la lista de reservas en el sistema.</p>
        </div>

        <div class="content">
            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Mensaje de error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="contenedor-tabla" style="min-height: 600px;" x-effect="updateHasResults()" x-data="{
                search: '',
                startDate: '',
                endDate: '',
                estadoSeleccionado: '',
                normalizeStr(str) {
                    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                },
                inDateRange(date) {
                    const d = new Date(date);
                    const start = new Date(this.startDate);
                    const end = new Date(this.endDate);
                    return (!this.startDate || d >= start) && (!this.endDate || d <= end);
                },
                currentReservaEstado: null,
                openCancelModal(reservaId, estado) {
                    this.currentCancelFormId = 'cancel-form-' + reservaId;
                    this.currentReservaEstado = estado;
                    var modal = new bootstrap.Modal(document.getElementById('cancelModal'));
                    modal.show();
                },
                confirmCancel() {
                    if (this.currentReservaEstado !== 'cancelada') {
                        document.getElementById(this.currentCancelFormId).submit();
                    }
                },
                hasResults: true,
                updateHasResults() {
                    this.$nextTick(() => {
                        console.log(this.$refs.tbody); // Para depurar
                        let rows = Array.from(this.$refs.tbody.querySelectorAll('tr:not(.no-results)'));
                        let visibleRows = rows.filter(row => row.style.display !== 'none').length;
                        this.hasResults = visibleRows > 0;
                        console.log('hasResults:', this.hasResults);
                    });
                },
                init() {
                    this.updateHasResults();
                },
            }">

                <!-- Buscador -->
                <div class="d-flex justify-content-center mb-3">
                    <input x-model="search" @input="updateHasResults()" type="text"
                        placeholder="Buscar por usuario (nombre, apellidos) o actividad..." class="form-control buscador"
                        style="text-align: center">
                </div>

                <div class="d-flex justify-content-center gap-2 mb-3">
                    <!-- Filtros de Fecha -->
                    <input x-model="startDate" @input="updateHasResults()" type="date" class="form-control">
                    <input x-model="endDate" @input="updateHasResults()" type="date" class="form-control">

                    <!-- Selector de Estado -->
                    <select x-model="estadoSeleccionado" @input="updateHasResults()" class="form-control">
                        <option value="">Todos los estados</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" id="cancelarReservasEnLote" class="btn btn-danger">Cancelar Reservas en
                        Lote</button>
                </div>

                <form id="batchCancelForm" action="{{ route('reservas.cancelarEnLote') }}" method="post"
                    style="display: none;">
                    @csrf
                    <input type="hidden" name="reservas" id="batchCancelInput">
                </form>


                <!-- Tabla de Reservas -->
                <table class="tabla table ">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Actividad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody x-ref="tbody">
                        @forelse ($reservas as $reserva)
                            <tr
                                x-show="(!search || normalizeStr(`{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido1 }} {{ $reserva->usuario->apellido2 }} {{ $reserva->actividad->nombre }}`).toLowerCase().includes(normalizeStr(search).toLowerCase())) && inDateRange('{{ $reserva->horario->fecha }}') && (!estadoSeleccionado || estadoSeleccionado === '{{ $reserva->estado }}')">
                                <td><input type="checkbox" class="reserva-checkbox" value="{{ $reserva->id }}"></td>
                                <td>{{ $reserva->id }}</td>
                                <td>{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido1 }}
                                    {{ $reserva->usuario->apellido2 }}</td>
                                <td>{{ $reserva->actividad->nombre }}</td>
                                <td>{{ $reserva->horario->fecha }}</td>
                                <td>{{ $reserva->horario->hora }}</td>
                                <td>{{ $reserva->estado }}</td>
                                <td>
                                    <form id="cancel-form-{{ $reserva->id }}"
                                        action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn btn-danger" ... data-toggle="tooltip"
                                            title="Cancelar reserva"
                                            onclick="openCancelModal({{ $reserva->id }}, '{{ strtolower($reserva->estado) }}')">
                                            <i class="fa fa-cancel"></i> Cancelar
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <!-- Fila de No Resultados -->
                            <tr x-show="!hasResults">
                                <td colspan="7" class="text-center">No se encontraron resultados para tu búsqueda.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                {{-- Enlaces de paginación --}}
                {{ $reservas->links() }}


                <!-- Modal de Confirmación -->
                <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelModalLabel">Confirmar Cancelación</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p id="cancelMessage"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-danger" id="confirmCancel">Confirmar
                                    Cancelación</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var currentCancelFormId = null;

        function openCancelModal(reservaId, estado) {
            currentCancelFormId = 'cancel-form-' + reservaId;
            var modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            var messageElement = document.getElementById('cancelMessage');

            if (estado === 'cancelada') {
                // Si el estado es 'cancelada', mostrar el mensaje correspondiente
                messageElement.textContent = 'Esta reserva ya está cancelada.';
                document.getElementById('confirmCancel').disabled = true; // Deshabilitar el botón de confirmación
            } else {
                // Si el estado no es 'cancelada', mostrar el otro mensaje
                messageElement.textContent = '¿Estás seguro de que deseas cancelar esta reserva?';
                document.getElementById('confirmCancel').disabled = false; // Habilitar el botón de confirmación
            }

            modal.show();
        }

        document.getElementById('confirmCancel').addEventListener('click', function() {
            document.getElementById(currentCancelFormId).submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('selectAll').addEventListener('change', function(e) {
                const checkboxes = document.querySelectorAll('.reserva-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
            });
        });

        // Cancelar reservas en lote
        document.getElementById('cancelarReservasEnLote').addEventListener('click', function() {
            let selectedReservas = Array.from(document.querySelectorAll('.reserva-checkbox:checked')).map(cb => cb
                .value);

            if (selectedReservas.length === 0) {
                alert('Por favor, selecciona al menos una reserva para cancelar.');
                return;
            }

            document.getElementById('batchCancelInput').value = JSON.stringify(selectedReservas);
            document.getElementById('batchCancelForm').submit();
        });
    </script>
@endsection
