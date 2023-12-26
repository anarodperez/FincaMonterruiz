@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Reservar Actividad</h4>
            <form class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="activityDate">Fecha de la reserva</label>
                    <input type="date" class="form-control" id="activityDate" required>
                </div>

                <div class="mb-3">
                    <label for="activityTime">Hora de la reserva</label>
                    <input type="time" class="form-control" id="activityTime" required>
                </div>

                <div class="mb-3">
                    <label for="activityLanguage">Idioma de la Actividad</label>
                    <select class="custom-select d-block w-100" id="activityLanguage" required>
                        <option value="">Elegir...</option>
                        <option>Español</option>
                        <option>Inglés</option>
                        <option>Alemán</option>
                        <!-- Añade más idiomas según sea necesario -->
                    </select>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continuar con la reserva</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        background-color: #0056b3;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0069d9;
    }
    /* Añade más estilos personalizados aquí */
</style>
@endsection
