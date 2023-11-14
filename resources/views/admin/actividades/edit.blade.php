@extends('layouts.admin')

@section('title')
    Editar Actividad
@endsection

@section('content')
    <div class="contenedor">
        <div class="card edit">
            <h5 class="card-header">Modificar Actividad</h5>
            <div class="card-body">
                <p class="card-text">
                <form action="{{ route('admin.actividades.update', $actividad->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label for="imagen">Imagen</label> <br>
                    <img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->nombre }}" style="width: 20%"> <br><br>
                    <input type="file" name="imagen" class="form-control-file"><br>

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $actividad->nombre }}">

                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control">{{ $actividad->descripcion }}</textarea>

                    <label for="duracion">Duración</label>
                    <input type="number" name="duracion" class="form-control" value="{{ $actividad->duracion }}">

                    <label for="precio_adulto">Precio adultos</label>
                    <input type="number" name="precio_adulto" class="form-control" value="{{ $actividad->precio_adulto }}">

                    <label for="precio_nino">Precio niños</label>
                    <input type="number" name="precio_nino" class="form-control" value="{{ $actividad->precio_nino }}">

                    <label for="aforo">Aforo</label>
                    <input type="number" name="aforo" class="form-control" value="{{ $actividad->aforo }}">

                    <label for="activa">Estado</label>
                    <select name="activa" class="form-control">
                        <option value="1" {{ $actividad->activa ? 'selected' : '' }}>Activar</option>
                        <option value="0" {{ !$actividad->activa ? 'selected' : '' }}>Inactivar</option>
                    </select>

                    {{-- <label for="categoria">Categoria</label>
                    <input type="text" name="categoria" class="form-control"> --}}
                    <br>
                    <a href="{{ route('admin.actividades.index') }}" class="btn btn-info">
                        <span class="fas fa-undo-alt"></span> Regresar
                    </a>
                    <button class="btn btn-warning">
                        <span class="fas fa-user-edit"></span> Actualizar
                    </button>
                </form>
                </p>

            </div>
        </div>
        <div>
        @endsection
