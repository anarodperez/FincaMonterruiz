@extends('layouts.guest')

@section('title', 'Reserva de Actividad')

@section('content')
<div class="activity-details-container">
    <div class="activity-info">
        <h2>Reservar la actividad</h2>
        <div class="activity-meta">
            <p><strong>Fecha de la reserva:</strong> 2024-01-12</p>
            <p><strong>Hora de la reserva:</strong> 10:30</p>
            <p><strong>Experiencia seleccionada:</strong> Tour y Cata</p>
            <p><strong>Precio por persona:</strong> 25.00€</p>
            <p><strong>Precio niños:</strong> 10.00€</p>
            <p><strong>Total:</strong> 0€</p>
        </div>
        <div class="activity-language">
            <p><strong>IDIOMA DE LA ACTIVIDAD:</strong></p>
            <p>Idioma: Inglés</p>
        </div>
    </div>
    <div class="reservation-form">
        <!-- Aquí va tu formulario de reserva -->
    </div>
</div>
<div class="activity-description">
    <p>Descripción</p>
    <p>Guided tour provides a walk through the vineyard, ...</p>
    <!-- Resto de la descripción -->
</div>
@endsection
