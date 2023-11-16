@extends('layouts.admin')

@section('title')
    Crear Actividad
@endsection

@section('content')
    <div class="container"
        style="display: flex;flex-direction: column;min-height: 80vh;margin-bottom: 20px; margin-top:20px">
        <div class="card">
            <h5 class="card-header">Crear Actividad</h5>
            <div class="card-body">
                <p class="card-text">
                <form action="{{ route('admin.actividades.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <label for="imagen">Imagen</label><br>
                    <input type="file" name="imagen" class="form-control-file" required> <br>

                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>

                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" required></textarea>

                    <label for="duracion">Duración</label>
                    <input type="number" name="duracion" class="form-control" required>

                    <label for="precio_adulto">Precio adultos</label>
                    <input type="number" name="precio_adulto" class="form-control" required>

                    <label for="precio_nino">Precio niños</label>
                    <input type="number" name="precio_nino" class="form-control" required>

                    <label for="aforo">Aforo</label>
                    <input type="number" name="aforo" class="form-control" required>

                    <label for="activa">Estado</label>
                    <select name="activa" class="form-control" required>
                        <option value="1">Activar</option>
                        <option value="0">Inactivar</option>
                    </select>
                    {{-- <label for="categoria_id">Categoria</label>
                    <input type="text" name="categoria_id" class="form-control" required> --}}

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
        <div>
        @endsection
