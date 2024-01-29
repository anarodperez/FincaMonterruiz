@extends('layouts.admin')

@section('title')
    Crear Newsletter
@endsection

@section('content')
    <div class="container" style="display: flex;flex-direction: column;min-height: 80vh;margin-bottom: 20px; margin-top:20px">
        <h2 class="my-4 text-center">Crear Nueva Newsletter</h2>

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

                <form action="{{ route('admin.newsletters.store') }}" method="POST">
                    @csrf

                    <!-- Título de la Newsletter -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>

                    <!-- Contenido de la Newsletter -->
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido</label>
                        <textarea id="contenido" name="contenido"></textarea>

                    </div>

                    <div class="mb-3">
                        <label for="imagen_url">URL de la Imagen</label>
                        <input type="text" class="form-control" id="imagen_url" name="imagen_url">
                    </div>

                    <div class="mb-3">
                        <label for="estado_envio">Estado de Envío</label>
                        <select class="form-control" id="estado_envio" name="estado_envio">
                            <option value="pendiente">Pendiente</option>
                            <option value="enviado">Enviado</option>
                            <option value="programado">Programado</option>
                        </select>
                    </div>


                    <a href="{{ route('admin.newsletters.index') }}" class="btn btn-info">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>

                    <!-- Botón para guardar la Newsletter -->
                    <button type="submit" class="btn btn-primary">   <i class="bi bi-save"> </i> Guardar</button>
                </form>
            </div>
            </p>
        </div>
    </div>

    <script>
         window.onload = function() {
            // Cierra la alerta después de 5 segundos (5000 milisegundos)
            $(".alert").delay(5000).slideUp(200, function() {
                $(this).alert('close');
            });
        };

        $('#contenido').trumbowyg({
            btns: ['bold', 'italic', 'underline', '|', 'unorderedList', 'orderedList',
                ['link'],
            ]
        });
    </script>
@endsection
