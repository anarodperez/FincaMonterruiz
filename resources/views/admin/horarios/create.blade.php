
@extends('layouts.admin')
@section('title')
    Crear Horario
@endsection

<style>
    form {
        margin-bottom: 6vh;
    }


    body {
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1;
        padding: 20px;
    }

    .error-list {
        list-style-type: none;
        padding-left: 0;
    }
</style>

@section('content')
    <div class="horario container">
        <h2 class="my-4 text-center">Crear Nuevo Horario</h2>
        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de creación de horarios -->
        <form class="create" action="{{ route('admin.horarios.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="actividad" class="form-label">Actividad:</label>
                <select name="actividad" id="actividad" class="form-select">
                    @foreach ($actividades as $actividad)
                        <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" name="fecha" id="fecha"
                    class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}">

            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" name="hora" id="hora" class="form-control @error('hora') is-invalid @enderror"
                    value="{{ old('hora') }}">

            </div>
            <div class="mb-3">
                <label for="idioma" class="form-label">Idioma:</label>
                <select name="idioma" id="idioma" class="form-select">
                    <option value="Español">Español</option>
                    <option value="Inglés">Inglés</option>
                    <option value="Francés">Francés</option>
                    <!-- Agrega otras opciones de idioma según tus necesidades -->
                </select>
            </div>
            <div class="mb-3">
                <label for="frecuencia" class="form-label">Frecuencia:</label>
                <select name="frecuencia" id="frecuencia" class="form-select" onchange="toggleRepeticiones()">
                    <option value="unico">Horario único</option>
                    <option value="diario">Diario</option>
                    <option value="semanal">Semanal</option>
                </select>
            </div>

            <div class="mb-3" id="divRepeticiones" style="display: none;">
                <label for="repeticiones" class="form-label">Repeticiones:</label>
                <input type="number" name="repeticiones" id="repeticiones" class="form-control"
                    value="{{ old('repeticiones') }}" min="1">
            </div>

            <a href="{{ route('admin.horarios.index') }}" class="btn btn-info">
                <i class="fas fa-arrow-left"></i>Regresar
            </a>
            <button type="submit" class="btn btn-primary">Guardar</button>

        </form>
    </div>
    <script>
        function toggleRepeticiones() {
            var frecuencia = document.getElementById('frecuencia').value;
            var divRepeticiones = document.getElementById('divRepeticiones');
            divRepeticiones.style.display = (frecuencia === 'diario' || frecuencia === 'semanal') ? 'block' : 'none';
        }

        // Ejecutar al cargar para establecer el estado inicial
        document.addEventListener('DOMContentLoaded', function() {
            toggleRepeticiones();
        });
    </script>
@endsection
