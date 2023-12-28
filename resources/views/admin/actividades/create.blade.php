@extends('layouts.admin')

@section('title')
    Crear Actividad
@endsection

@section('content')
    <div class="container" style="display: flex;flex-direction: column;min-height: 80vh;margin-bottom: 20px; margin-top:20px">
        @if ($errors->has('precios'))
            <div class="alert alert-danger">
                {{ $errors->first('precios') }}
            </div>
        @endif
        <div class="card">
            <h5 class="card-header">Crear Actividad</h5>
            <div class="card-body">
                <p class="card-text">
                <form action="{{ route('admin.actividades.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <label for="imagen">Imagen</label><br>
                    <input type="file" name="imagen" class="form-control-file" value="{{ old('imagen') }}" required>
                    <br>

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>

                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>

                    <label for="duracion">Duración</label>
                    <input type="number" name="duracion" class="form-control" value="{{ old('duracion') }}" required>

                    <label for="precio_adulto">Precio adultos</label>
                    <input type="number" name="precio_adulto" value="{{ old('precio_adulto') }}" class="form-control"
                        placeholder="Dejar en blanco si es solo para niños">

                    <label for="precio_nino">Precio niños</label>
                    <input type="number" name="precio_nino" value="{{ old('precio_nino') }}" class="form-control"
                        placeholder="Dejar en blanco si es solo para adultos">

                    <label for="aforo">Aforo</label>
                    <input type="number" name="aforo" class="form-control" value="{{ old('aforo') }}" required>

                    <label for="activa">Estado</label>
                    <select name="activa" class="form-control" required>
                        <option value="1" {{ old('activa') == '1' ? 'selected' : '' }}>Activar</option>
                        <option value="0" {{ old('activa') == '0' ? 'selected' : '' }}>Inactivar</option>
                    </select>

                    <br>
                    <a href="{{ route('admin.actividades.index') }}" class="btn btn-info">
                        <span class="fas fa-undo-alt"></span> Regresar
                    </a>
                    <button class="btn btn-warning">
                        <span class="fas fa-user-edit"></span> Agregar
                    </button>
                </form>
                </p>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            // Cierra la alerta después de 5 segundos (5000 milisegundos)
            $(".alert").delay(5000).slideUp(200, function() {
                $(this).alert('close');
            });
        };
    </script>

@endsection
