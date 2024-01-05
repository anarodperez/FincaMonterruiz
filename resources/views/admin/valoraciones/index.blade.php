@extends('layouts.admin')
@section('content')
    <style>
        .valoraciones-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* Espacio entre tarjetas */
        }

        .valoracion-card {
            background-color: #f4f4f4;
            border-left: 5px solid #5c7c64;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .valoracion-card h3 {
            color: #550d0e;
        }

        .valoracion-card p {
            color: #000000;
        }

        .star-rating {
            color: #fdd835;
            font-size: 25px;
        }
    </style>
  <div class="container">
    <div class="text-center my-4">
        <h2 class="display-4 font-weight-bold text-primary">Valoraciones de los usuarios</h2>
        <p class="lead">Descubre y gestiona la lista de valoraciones de los usuarios.</p>
    </div>

    <div class="row">
        @foreach ($valoraciones as $valoracion)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100 valoracion-card">
                    <div class="card-body">
                        <h3 class="card-title">{{ $valoracion->actividad->nombre }}</h3>
                        <p class="card-text">
                            <strong>Valorado por: </strong>{{ $valoracion->user->nombre }} {{ $valoracion->user->apellido1 }} {{ $valoracion->user->apellido2 }}
                        </p>
                        <div class="star-rating">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $valoracion->puntuacion)
                                    <span class="text-warning">★</span>
                                @else
                                    <span class="text-secondary">★</span>
                                @endif
                            @endfor
                        </div>
                        <p><strong>Comentario: </strong>{{ $valoracion->comentario }}</p>
                        <p class="text-muted card-text">{{ $valoracion->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
     <!-- Enlaces de paginación -->
     {{ $valoraciones->links() }}
</div>

@endsection
