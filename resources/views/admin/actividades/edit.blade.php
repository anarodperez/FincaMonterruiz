@extends('layouts.admin')

@section('title')
    Editar Actividad
@endsection

@section('content')
    <div class="contenedor">
        <h2 class="my-4 text-center">Modificar actividad</h2>
        <div class="card edit">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="card-header">
                Datos de la Actividad
            </div>
            <div class="card-body">
                <p class="card-text">
                    <form action="{{ route('admin.actividades.update', $actividad->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3  margenes-laterales">
                            <label for="imagen" class="mb-2">Imagen</label> <br>
                            <img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->nombre }}" style="width: 20%">
                            <br><br>
                            <input type="file" name="imagen" class="form-control-file"><br>
                        </div>
                        <div class="form-group mb-3  margenes-laterales">
                            <label for="nombre" class="mb-2">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $actividad->nombre }}" {{ $tieneReservas ? 'disabled
                            ' : '' }}>
                        </div>
                        <div class="form-group mb-3  margenes-laterales">
                            <label for="descripcion" class="mb-2">Descripción</label>
                            <textarea name="descripcion" class="form-control">{{ $actividad->descripcion }}</textarea>
                        </div>
                        <div class="form-group mb-3  margenes-laterales">
                            <label for="duracion" class="mb-2">Duración</label>
                            <input type="number" name="duracion" class="form-control" value="{{ $actividad->duracion }}" {{ $tieneReservas ? 'disabled
                            ' : '' }}>
                        </div>
                        <div class="row mb-3  margenes-laterales">
                            <div class="col-md-6">
                                <label for="precio_adulto" class="form-label">Precio Adultos</label>
                                <input type="number" name="precio_adulto" class="form-control" value="{{ $actividad->precio_adulto }}"  min="0" {{ $tieneReservas ? 'disabled
                                ' : '' }}>
                            </div>
                            <div class="col-md-6">
                                <label for="precio_nino" class="form-label">Precio Niños</label>
                                <input type="number" name="precio_nino" class="form-control" value="{{ $actividad->precio_nino }}"  min="0" {{ $tieneReservas ? 'disabled
                                ' : '' }}>
                            </div>
                        </div>
                        <div class="row mb-3  margenes-laterales">
                            <div class="col-md-6">
                                <label for="aforo" class="form-label">Aforo Máximo</label>
                                <input type="number" name="aforo" class="form-control" value="{{ $actividad->aforo }}"  min="0" {{ $tieneReservas ? 'disabled
                                ' : '' }}>
                            </div>
                            <div class="col-md-6">
                                <label for="activa" class="form-label">Estado de la Actividad</label>
                                <select name="activa" class="form-control" {{ $tieneReservas ? 'disabled
                                ' : '' }}>
                                    <option value="1" {{ $actividad->activa ? 'selected' : '' }}>Activa</option>
                                    <option value="0" {{ !$actividad->activa ? 'selected' : '' }}>Inactiva</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <a href="{{ route('admin.actividades.index') }}" class="btn btn-info" style="margin-left: 20px">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                        <button class="btn btn-warning">
                            <span class="fas fa-user-edit"></span> Actualizar
                        </button>
                    </form>
                </p>
            </div>
        </div>
    </div>
@endsection
