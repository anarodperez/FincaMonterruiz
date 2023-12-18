@extends('layouts.guest')

@section('title', 'Galería de Imágenes')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
@endsection

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row">
                <!-- Campo de búsqueda -->
                <div class="mb-4">
                    <form action="{{ route('actividades.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="buscador" id="search" class="form-control"
                                placeholder="Escribe el nombre de la actividad">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Filtros en el aside -->
                <aside class="col-md-3">
                    <div class="mb-4">
                        <h3>Filtrar Actividades</h3>
                        <form action="{{ route('actividades.filter') }}" method="GET">
                            <div class="form-group">
                                <label for="categoria">Categoría:</label>
                                <select name="categoria" id="categoria" class="form-control">
                                    <option value="">Todas</option>
                                    <option value="aventura">Aventura</option>
                                    <option value="naturaleza">Naturaleza</option>
                                    <!-- Agrega más opciones de categoría aquí -->
                                </select>
                            </div>

                                <!-- ... otros campos de filtro ... -->
                                <div class="form-group">
                                    <label for="precio">Precio:</label>
                                    <select name="precio" id="precio" class="form-control">
                                        <option value="">Cualquier Precio</option>
                                        <option value="bajo">Bajo</option>
                                        <option value="medio">Medio</option>
                                        <option value="alto">Alto</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </form>
                    </div>
                </aside>

                <!-- Contenido principal -->
                <div class="col-md-9">
                    <!-- Encabezado -->
                    <header class="jumbotron">
                        <div class="container text-center">
                            <h1>Descubre Nuestras Actividades</h1>
                            <p>Explora una variedad de actividades emocionantes para todas las edades.</p>
                        </div>
                    </header>

                    <!-- Catálogo de Actividades -->
                    <section class="my-5">
                        <div class="row">
                            <!-- Actividades se mostrarán aquí -->
                            @foreach ($actividades as $actividad)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="{{ asset($actividad->imagen) }}" alt="{{ $actividad->nombre }}"
                                            class="card-img-top" alt="{{ $actividad->nombre }}">
                                        <div class="card-body">
                                            <h2 class="card-title">{{ $actividad->nombre }}</h2>
                                            <p class="card-text">{{ $actividad->descripcion }}</p>
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>Duración:</strong>
                                                    {{ $actividad->duracion }} min</li>
                                                <li class="list-group-item"><strong>Precio adulto:</strong>
                                                    {{ $actividad->precio_adulto }} €
                                                </li>
                                                <li class="list-group-item"><strong>Precio niño:</strong>
                                                    {{ $actividad->precio_nino }} €
                                                </li>
                                                </li>
                                                <li class="list-group-item"><strong>Aforo:</strong>
                                                    {{ $actividad->aforo }}</li>
                                            </ul>
                                            {{-- <a href="{{ route('actividades.show', $actividad->id) }}" class="btn btn-primary mt-3">Ver Detalles</a> --}}
                                            <!-- Agrega el botón "Reservar" -->
                                            <div class="lc-block">
                                                <button class="custom-btn boton">RESERVAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection
