<!-- admin/horarios/create.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">Crear Nuevo Horario</h2>
        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label for="actividad" class="form-label">Actividad:</label>
                <select name="actividad" id="actividad" class="form-select">
                    <!-- Opciones para seleccionar la actividad -->
                    <option value="1">Actividad 1</option>
                    <option value="2">Actividad 2</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <div class="mb-3">
                <label for="dias_semana" class="form-label">Días de la Semana:</label>
                <input type="text" name="dias_semana" id="dias_semana" class="form-control" placeholder="Ej. Lunes, Miércoles, Viernes">
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" name="hora" id="hora" class="form-control">
            </div>
            <!-- Agrega otros campos según sea necesario -->
            <button type="submit" class="btn btn-primary">Guardar Horario</button>
        </form>
    </div>
@endsection
