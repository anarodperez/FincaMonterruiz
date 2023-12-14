@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="my-4 text-center">Crear Nuevo Horario</h2>
        <!-- Aquí puedes agregar el resto de tu código de formulario -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Resto del formulario -->
        <form action="{{ route('admin.horarios.store') }}" method="POST" style="min-height: 650px;">
            @csrf
            <div class="mb-3">
                <label for="actividad" class="form-label">Actividad:</label>
                <select name="actividad" id="actividad" class="form-select">
                    <!-- Itera sobre las actividades para cargarlas dinámicamente -->
                    @foreach ($actividades as $actividad)
                        <option value="{{ $actividad->id }}">{{ $actividad->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" name="fecha" id="fecha"
                    class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha') }}">
                @error('fecha')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
            <div class="mb-3">
                <label for="frecuencia" class="form-label">Frecuencia:</label>
                <select name="frecuencia" id="frecuencia" class="form-select">
                    <option value="unico">Horario único</option>
                    <option value="diario">Diario</option>
                    <option value="semanal">Semanal</option>
                    <!-- Agrega otras opciones de frecuencia según tus necesidades -->
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
