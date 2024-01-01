 {{-- Reservas Activas --}}
 <h3>Reservas Activas</h3>
 <div class="row">
     @foreach ($reservasActivas as $reserva)
         <div class="card card-reserva">
             <div class="card-body">
                 <h5 class="card-title">{{ $reserva->nombre_actividad }}</h5>
                 <p class="card-text">Fecha: {{ $reserva->horario->fecha }}</p>
                 <p class="card-text">Hora: {{ $reserva->horario->hora }}</p>
                 <p class="card-text">Estado: {{ $reserva->estado }}</p>
                 <a href="" class="btn btn-danger">Cancelar Reserva</a>
             </div>
     @endforeach
 </div>

 {{-- Reservas Pasadas --}}
 <h3>Reservas Pasadas</h3>
 <div class="row">
     @foreach ($reservasPasadas as $reserva)
         <p class="card-text">Fecha: {{ $reserva->horario->fecha }}</p>
         <p class="card-text">Hora: {{ $reserva->horario->hora }}</p>
         <p class="card-text">Estado: {{ $reserva->estado }}</p>
     @endforeach
 </div>
