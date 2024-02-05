@extends('layouts.admin')

@section('title')
    Crear Actividad
@endsection

@section('content')
    <div class="container" style="display: flex;flex-direction: column;min-height: 80vh;margin-bottom: 20px; margin-top:20px">
        <h2 class="my-4 text-center">Crear Nueva Actividad</h2>
        @if ($errors->has('precios'))
            <div class="alert alert-danger">
                {{ $errors->first('precios') }}
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

        <div class="card">
            <div class="card-body">
                <p class="card-text">
                <form action="{{ route('admin.actividades.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset class=" margenes-laterales">
                        <legend>Información Básica</legend>
                        <div class="form-group mb-3 ">
                            <label for="imagen" class="mb-2">Imagen</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="imagen" name="imagen" class="custom-file-input"
                                        aria-describedby="fileHelp" required>
                                    <label class="custom-file-label" for="imagen">Elegir archivo</label>
                                </div>
                            </div>
                            <small id="fileHelp" class="form-text text-muted">Sube una imagen representativa de la
                                actividad.</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nombre" class="mb-2">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="descripcion" class="mb-2">Descripción</label>
                            <textarea name="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="duracion" class="mb-2">Duración</label>
                            <input type="number" name="duracion" class="form-control" value="{{ old('duracion') }}"
                                required>
                            @error('duracion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <fieldset  margenes-laterales>
                            <legend>Precios</legend>
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="precio_adulto" class="mb-2">Precio adultos</label>
                                    <input type="number" name="precio_adulto" value="{{ old('precio_adulto') }}"
                                        class="form-control" min="0" required>
                                    @error('precio_adulto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="precio_nino" class="mb-2">Precio niños</label>
                                    <input type="number" name="precio_nino" value="{{ old('precio_nino') }}"
                                        class="form-control" placeholder="Dejar en blanco si es solo para adultos"
                                        min="0">
                                    @error('precio_nino')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <fieldset  margenes-laterales>
                            <legend>Configuraciones Adicionales</legend>
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="aforo" class="mb-2">Aforo</label>
                                    <input type="number" name="aforo" class="form-control" value="{{ old('aforo') }}"
                                        min="0" required>
                                    @error('aforo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="activa" class="mb-2">Estado</label>
                                    <select name="activa" class="form-control" required>
                                        <option value="1" {{ old('activa') == '1' ? 'selected' : '' }}>Activar
                                        </option>
                                        <option value="0" {{ old('activa') == '0' ? 'selected' : '' }}>Inactivar
                                        </option>
                                    </select>
                                    @error('activa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <a href="{{ route('admin.actividades.index') }}" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                        <button class="btn btn-warning">
                            <span class="fas fa-user-edit"></span> Agregar
                        </button>
                    </fieldset>
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
