@extends('layouts.admin')

@section('title')
    Editar Newsletter
@endsection

@section('content')
    <div class="container" style="display: flex;flex-direction: column;min-height: 80vh;margin-bottom: 20px; margin-top:20px">
        <h2 class="my-4 text-center">Editar Newsletter</h2>

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

                <form action="{{ route('admin.newsletters.update', $newsletter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            value="{{ $newsletter->titulo }}">
                    </div>

                    <div class="mb-3">
                        <label for="contenido" class="form-label">Contenido</label>
                        <textarea id="contenido" name="contenido">{!! html_entity_decode($newsletter->contenido) !!}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <!-- Mostrar la imagen actual -->
                        @if ($newsletter->imagen_url)
                            <div>
                                <img src="{{ asset($newsletter->imagen_url) }}" alt="Imagen actual" style="max-width: 100px; height: auto;">
                                <p>Imagen actual</p>
                            </div>
                        @endif
                        <!-- Campo para subir una nueva imagen -->
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>


                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
                </p>
            </div>
        </div>
    </div>

    <script>
        $('#contenido').trumbowyg({
            btns: ['bold', 'italic', 'underline', '|', 'unorderedList', 'orderedList',
                ['link'],
            ]
        });
    </script>
@endsection
