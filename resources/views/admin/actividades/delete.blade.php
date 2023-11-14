@extends('layouts.admin')

@section('title')
    Eliminar Actividad
@endsection

@section('content')
    <div class="content">
        <div class="card delete">
            <h5 class="card-header">Eliminar Actividad</h5>
            <div class="card-body">
                <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿ESTÁS SEGURO QUE DESEA BORRAR ESTA ACTIVIDAD?

                    <table class="tabla table-sm table-hover table-bordered" style="background-color: white">
                        <thead>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Precio adulto</th>
                            <th>Precio precio</th>
                            <th>Aforo</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->nombre }}"></td>
                                <td>{{ $actividad->nombre }}</td>
                                <td>{{ $actividad->descripcion }}</td>
                                <td>{{ $actividad->duracion }}</td>
                                <td>{{ $actividad->precio_adulto }}</td>
                                <td>{{ $actividad->precio_ninio}}</td>
                                <td>{{ $actividad->aforo }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('admin.actividades.delete', ['actividad' => encrypt($actividad->id)]) }}" method="POST">

                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.actividades.index') }}" class="btn btn-info">
                            <span class="fas fa-undo-alt"></span> Regresar
                        </a>
                        <button class="btn btn-danger" >
                            <span class="fas fa-times"></span> Eliminar
                        </button>
                    </form>
                </div>
                </p>
            </div>
        </div>
    @endsection
