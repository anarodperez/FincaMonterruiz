@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">Crear Nuevo Horario</h2>
        <form action="{{ route('admin.horarios.store') }}" method="POST" style="min-height: 650px;">
            @csrf
            <div class="mb-3">
                <label for="actividad" class="form-label">Actividad:</label>
                <select name="actividad" id="actividad" class="form-select">
                    <!-- Itera sobre las actividades para cargarlas dinámicamente -->
                    @foreach($actividades as $actividad)
                        <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="dia_semana" class="form-label">Día de la Semana:</label>
                <select name="dia_semana" id="dia_semana" class="form-select">
                    <!-- Opciones para seleccionar el día de la semana -->
                    <option value="domingo">Domingo</option>
                    <option value="lunes">Lunes</option>
                    <option value="martes">Martes</option>
                    <option value="miercoles">Miércoles</option>
                    <option value="jueves">Jueves</option>
                    <option value="viernes">Viernes</option>
                    <option value="sabado">Sábado</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" name="hora" id="hora" class="form-control">
            </div>
            <div class="mb-3">
                <label for="idioma" class="form-label">Idioma:</label>
                <select name="idioma" id="idioma" class="form-select">
                    <option value="Español">Español</option>
                    <option value="Inglés">Inglés</option>
                    <option value="Frances">Francés</option>
                </select>
            </div>
            <!-- Agrega otros campos según sea necesario -->
            <button type="submit" class="btn btn-primary">Guardar Horario</button>
            <a href="{{ route('admin.horarios.index') }}" class="btn btn-info">
                <span class="fas fa-undo-alt"></span> Regresar
            </a>
        </form>
    </div>
@endsection
