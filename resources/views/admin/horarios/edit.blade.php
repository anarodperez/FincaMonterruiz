@extends('layouts.admin')

@section('content')
<div class="container editar-horario">
    <h2 class="mb-4">Editar Horario</h2>
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.horarios.update', $horario->id) }}" method="POST" class="border p-4 rounded">
        @csrf
        @method('PUT')

        @if($esRecurrente)
        <fieldset class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0">Tipo de Edición:</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_edicion" id="editarEsta" value="instancia" checked>
                    <label class="form-check-label" for="editarEsta">
                        Editar solo esta instancia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_edicion" id="editarSerie" value="serie">
                    <label class="form-check-label" for="editarSerie">
                        Editar toda la serie
                    </label>
                </div>
            </div>
        </fieldset>
    @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="actividad" class="form-label">Actividad:</label>
                <input type="text" id="actividad" class="form-control" value="{{ $horario->actividad->nombre }}" disabled>
                <input type="hidden" name="actividad" value="{{ $horario->actividad_id }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $horario->fecha }}" @if($esRecurrente) disabled @endif required>
            </div>
            <div class="col-md-6">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" id="hora" name="hora" class="form-control" value="{{ $horario->hora }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="idioma" class="form-label">Idioma:</label>
                <select id="idioma" name="idioma" class="form-select">
                    <option value="Español" {{ $horario->idioma == 'Español' ? 'selected' : '' }}>Español</option>
                    <option value="Inglés" {{ $horario->idioma == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                    <option value="Francés" {{ $horario->idioma == 'Francés' ? 'selected' : '' }}>Francés</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Horario</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        // Verificar inicialmente cuál opción está seleccionada
        toggleFechaField();

        // Escuchar cambios en las opciones de tipo de edición
        $('input[name="tipo_edicion"]').change(function() {
            toggleFechaField();
        });

        function toggleFechaField() {
            // Si "Editar solo esta instancia" está seleccionado, habilitar el campo fecha
            if ($('#editarEsta').is(':checked')) {
                $('#fecha').prop('disabled', false);
            } else {
                $('#fecha').prop('disabled', true);
            }
        }
    });
    </script>

@endsection
